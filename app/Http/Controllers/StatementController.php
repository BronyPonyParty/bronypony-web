<?php

namespace App\Http\Controllers;

use App\Models\Repair;
use App\Models\Report;
use App\Models\Technic;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as AuthFacade;
use Illuminate\Support\Facades\Validator;

class StatementController extends Controller
{
    public function get() {
        $user = AuthFacade::user();

        // Берём список заявлений состояния которых равняется 1-му или 2-ум,
        // а также делаем подзапрос в таблицу technics и берём технику которая находится в организации подавшая заявление
        $reports = Report::whereHas('technic', $filter = function ($query) use ($user) {
            $query->select('id','name','number','cabinet')->where('organization_id', $user->organization_id);
        })->with(['technic' => $filter])
            ->select(['id', 'technic_id', 'user_id', 'description', 'create_date', 'status'])
            ->whereIn('status', [1, 2])
            ->get();

        // Если нету заявлений то код дальше не выполняется
        if (empty($reports[0])) return [];

        // Берём ids техники и заявлений
        $technicIds = [];
        $reportsIds = [];
        foreach ($reports as $report) {
            $reportsIds[] = $report->id;
            if (!in_array($report->technic_id, $technicIds)) $technicIds[] = $report->technic_id;
        };

        // Создаём массив ключей, где ключём является report_id, а значением запись repair из таблицы repairs
        // Делаем запрос в таблицу Repairs, где достаём такие поля как report_id и repairman_id по отбору Ids
        $repairReportRow = [];
        $repairs = Repair::select(['report_id', 'repairman_id'])->whereIn('report_id', $reportsIds)->get();
        foreach ($repairs as $repair) $repairReportRow[$repair->report_id] = $repair;

        // Вносим в массив данные о пользователях которые учавствовали в заявлениях
        $userIds = [];
        foreach ($reports as $report) if (!in_array($report->user_id, $userIds)) $userIds[] = $report->user_id;
        foreach ($repairs as $repair) if (!in_array($repair->repairman_id, $userIds)) $userIds[] = $repair->repairman_id;

        // Делаем запрос в таблицу users, выбираем определённые поля, отбираем ids по условию и получаем данные
        $users = User::select(['id', 'firstname', 'lastname'])->whereIn('id', $userIds)->get();

        $userNames = [];
        foreach ($users as $user) $userNames[$user->id] = $user;

        $mass = [];
        foreach ($reports as $report) {
            // Проверяем чему равен статус текущего заявления, если 1 то возврашаем пустоту, иначе возвращаем Фамилию и Имя
            $repairMan = $report->status === 1 ? '' : $userNames[$repairReportRow[$report->id]->repairman_id]->firstname .
                ' ' . $userNames[$repairReportRow[$report->id]->repairman_id]->lastname;

            // Проверяем чему равен статус текущего заявления, если 1 то возврашаем пустоту, id ремонтника
            $repairManId = $report->status === 1 ? '' : $repairReportRow[$report->id]->repairman_id;

            $mass[] = [
                'id' => $report->id,
                'techName' => $report->technic->name,
                'techNumber' => $report->technic->number,
                'date' => $report->create_date,
                'user' => $userNames[$report->user_id]->firstname . ' ' . $userNames[$report->user_id]->lastname,
                'description' => $report->description,
                'repairMan' => $repairMan,
                'repairManId' => $repairManId,
                'cabinet' => $report->technic->cabinet,
                'status' => $report->status,
            ];
        }

        return $mass;
    }

    public function accept(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            abort(400, json_encode('Хм. Данная ошибка не должна была возникнуть не прикаких обстоятельствах'));
        }

        $user = AuthFacade::user();
        $report_id = $request->post('id');

        // Запрос на взятие данных из таблицы reports, где берём только те поля в которых user_id из нашей организации.
        // Также из таблицы reports берём только те поля, которые имею статус 1 и берём поле с переданным report_id
        $report = Report::whereHas('user', function ($query) use ($user) {
            $query->where('organization_id', $user->organization_id);
        })->select('id')->where('status', 1)->where('id', $report_id)->first();

        if (empty($report)) abort(400, json_encode('Вы пытаетесь взять заявление которого не существует, либо оно кем-то занято'));


        $report->status = 2;
        $report->save();

        $repair = new Repair;
        $repair->report_id = $report->id;
        $repair->repairman_id = $user->id;
        $repair->save();

        return 'OK';
    }

    public function complete(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
            'description' => 'max:512'
        ]);

        if ($validator->fails()) {
            abort(400, json_encode('Хм. Данная ошибка не должна была возникнуть не прикаких обстоятельствах'));
        }

        $user = AuthFacade::user();
        $report_id = $request->post('id');
        $description = $request->post('description');

        // Делаем запрос в таблицу repairs и выполняем подзапрос где по условию достём только ту запись
        // которую нужно завершить, и дополнительным условием проверяем её статус, дабы избежать повторного сохранения,
        // также по условию авторизованный пользователь должен быть ремонтником
        $repair = Repair::whereHas('report', $filter = function ($query) use ($report_id) {
            $query->with('technic:id,status')->where('id', $report_id)->where('status', 2);
        })->with(['report' => $filter])->where('repairman_id', $user->id)->first();

        if (empty($repair)) abort(400, json_encode('Данного заявления не существует'));

        $repair->description = $description;
        $repair->save();

        $repair->report->status = 4;
        $repair->report->complete_date = time();
        $repair->report->save();

        $repair->report->technic->status = 4;
        $repair->report->technic->save();

        return $repair->report->technic_id;
    }

    public function add(Request $request) {
        $validator = Validator::make($request->all(), [
            'number' => 'required|integer',
            'description' => 'max:512'
        ]);

        if ($validator->fails()) abort(400, json_encode('Неверные данные'));

        $number = $request->post('number');
        $description = preg_replace("/\s+/u", " ", str_replace(array("\r\n", "\r", "\n"), '', $request->post('description')));
        $authUser = AuthFacade::user();

        $technic = Technic::select(['id', 'name', 'cabinet', 'status'])->where('organization_id', $authUser->organization_id)->where('number', $number)->first();
        if (empty($technic)) abort(400, json_encode('Данной техники не существует в вашей организации'));
        if ($technic->status == 2) abort(400, json_encode('Данная техника уже ожидает ремонта'));

        $report = new Report();
        $report->technic_id = $technic->id;
        $report->user_id = $authUser->id;
        if (!empty($description)) $report->description = $description;
        $report->create_date = time();
        $report->status = 1;
        $report->save();

        $technic->status = 2;
        $technic->save();

        $mass = [
            'reportId' => $report->id,
            'techId' => $technic->id,
            'name' => $technic->name,
            'cabinet' => $technic->cabinet
        ];

        return $mass;
    }
}
