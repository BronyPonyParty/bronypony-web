<?php

namespace App\Http\Controllers;

use App\Models\MovingTechnic;
use App\Models\Premise;
use App\Models\Repair;
use App\Models\Technic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as AuthFacade;
use Illuminate\Support\Facades\Validator;

class TechnicController extends Controller
{
    public function getList() {
        $user = AuthFacade::user();

        // Запрос на взятие техники с условием, что техника находится в организации из которой пользователь подал запрос
        // и также с условием, что техника не удалена
        $technics = Technic::select(['id','name','number','cabinet','date_added','description','status'])
            ->where('organization_id', $user->organization_id)->where('status', '!=', 1)->get();

        $mass = [];
        foreach ($technics as $technic) {
            $mass[] = [
                'id' => $technic->id,
                'name' => $technic->name,
                'number' => $technic->number,
                'cabinet' => $technic->cabinet,
                'date' => $technic->date_added,
                'description' => $technic->description,
                'status' => $technic->status
            ];
        }

        return $mass;
    }

    public function getInfo(Request $request) {
        $validator = Validator::make($request->all(), [
            'technic_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            abort(400, json_encode('Хм. Данная ошибка не должна была возникнуть не прикаких обстоятельствах'));
        }

        $user = AuthFacade::user();
        $technic_id = $request->get('technic_id');

        // Получаем историю передвижения техники с условием, technic_id = id нужной нам техники
        // Исключаем возможность получить данные из разных организаций
        $movingTechnics = MovingTechnic::whereHas('user', function ($query) use ($user, $technic_id) {
            $query->where('organization_id', $user->organization_id);
        })->with('user:id,firstname,lastname', 'premise:id,number')
            ->select(['id', 'user_id', 'premise_id', 'date'])
            ->where('technic_id', $technic_id)
            ->get();


        $movingMass = [];
        foreach ($movingTechnics as $technic) {
            $movingMass[] = [
                'id' => $technic->id,
                'user' => $technic->user->firstname . ' ' . $technic->user->lastname,
                'number' => $technic->premise->number,
                'date' => $technic->date
            ];
        }

        // Делаю запрос к таблицы Repairs, дальше через связь обращаюсь к таблице reports,
        // внутри также обращаюсь через связь к таблице technics и по условиям отбираю
        // id техники = technic_id который отправил пользователь,
        // также по условию в таблице reports status = 4,
        // в итоге получаем данные в таблице Repairs отобранные по этим условиям.
        // Исключаем возможность получить данные из разных организаций
        $repairs = Repair::whereHas('report', $filters = function ($query) use ($technic_id, $user) {
            $query->whereHas('technic', function ($query) use ($technic_id, $user) {
                $query->where('id', $technic_id)
                    ->where('organization_id', $user->organization_id);
            })->with('user:id,firstname,lastname')
                ->select(['id', 'user_id', 'description', 'create_date', 'complete_date'])
                ->where('status', 4);})
            ->with(['user:id,firstname,lastname', 'report' => $filters])
            ->get();

        if (empty($repairs[0])) return [$movingMass, []];

        $repairMass = [];
        foreach ($repairs as $repair) {
            $repairMass[] = [
                'id' => $repair->id,
                'user' => $repair->report->user->firstname . ' ' . $repair->report->user->lastname,
                'repairman' => $repair->user->firstname . ' ' . $repair->user->lastname,
                'userDescription' => $repair->report->description,
                'repairmanDescription' => $repair->description,
                'startDate' => $repair->report->create_date,
                'endDate' => $repair->report->complete_date
            ];
        }

        return [$movingMass, $repairMass];
    }

    public function move(Request $request) {
        $validator = Validator::make($request->all(), [
            'cabinet' => 'required|max:6',
            'technicId' => 'required|int'
        ]);

        if ($validator->fails()) return response(['errors' => $validator->failed()], 400);

        $user = AuthFacade::user();
        $cabinet = $request->post('cabinet');
        $technicId = $request->post('technicId');

        $premise = Premise::select('id')->where('number', $cabinet)->where('organization_id', $user->organization_id)->first();
        if (empty($premise)) return response(['errors' => ['cabinet' => ['NotFound' => []]]], 400);

        $movingTechnic = new MovingTechnic();
        $movingTechnic->user_id = $user->id;
        $movingTechnic->technic_id = $technicId;
        $movingTechnic->premise_id = $premise->id;
        $movingTechnic->date = time();
        $movingTechnic->save();

        return time();
    }


    //access level 8
    public function changeDescription(Request $request) {
        $validator = Validator::make($request->all(), [
            'description' => 'max:1024',
            'technicId' => 'required|int'
        ]);

        if ($validator->fails()) return response(['errors' => $validator->failed()], 400);

        $user = AuthFacade::user();
        $description = $request->post('description');
        $technicId = $request->post('technicId');

        $technic = Technic::where('id', $technicId)->where('organization_id', $user->organization_id)->update(['description' => $description]);
        if ($technic == 0) return response(['errors' => ['technicId' => ['NotFound' => []]]], 400);

        return 'OK';
    }

    public function add(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:64',
            'number' => 'required|max:10',
            'description' => 'max:1024',
        ]);

        if ($validator->fails()) return response(['errors' => $validator->failed()], 400);

        $authUser = AuthFacade::user();
        $name = $request->post('name');
        $number = trim($request->post('number'));
        $description = preg_replace("/\s+/u", " ", str_replace(array("\r\n", "\r", "\n"), '', $request->post('description')));

        if (!ctype_digit($number)) return response(['errors' => ['number' => ['Integer' => []]]], 400);
        if ($number[0] == 0) return response(['errors' => ['number' => ['Zero' => []]]], 400);

        $unique = Technic::where('organization_id', $authUser->organization_id)->where('number', $number)->where('status', '!=', 1)->first();
        if (!empty($unique)) return response(['errors' => ['number' => ['Busy' => []]]], 400);

        $technic = new Technic();
        $technic->name = $name;
        $technic->number = $number;
        $technic->date_added = time();
        $technic->description = $description;
        $technic->organization_id = $authUser->organization_id;
        $technic->status = 4;
        $technic->save();

        return $technic->id;
    }

    public function delete(Request $request) {
        $validator = Validator::make($request->all(), [
            'techId' => 'required|integer'
        ]);

        if ($validator->fails()) return response(['errors' => $validator->failed()], 400);

        $deleteTechId = $request->post('techId');
        $authUser = AuthFacade::user();

        $tech = Technic::where('id', $deleteTechId)->where('organization_id', $authUser->organization_id)
            ->where('status', '!=', 1)->update(['status' => 1]);

        if ($tech === 0) return response(['errors' => ['techId' => ['NotFound' => []]]], 400);

        return 'OK';
    }
}
