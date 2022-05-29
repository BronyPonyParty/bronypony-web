<?php

namespace App\Http\Controllers;

use App\Models\Repair;
use App\Models\Report;
use App\Models\Technic;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as AuthFacade;
use Illuminate\Support\Facades\DB;

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

            $mass[] = [
                'technicName' => $report->technic->name,
                'technicNumber' => $report->technic->number,
                'date' => $report->create_date,
                'user' => $userNames[$report->user_id]->firstname . ' ' . $userNames[$report->user_id]->lastname,
                'userDescription' => $report->description,
                'repairMan' => $repairMan,
                'cabinet' => $report->technic->cabinet,
                'status' => $report->status,
            ];
        }

        return $mass;
    }

    public function accept() {

    }

    public function complete() {

    }
}
