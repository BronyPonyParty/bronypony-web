<?php

namespace App\Http\Controllers;

use App\Models\MovingTechnic;
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
        $technics = Technic::with('provider:id,name')
            ->select(['id','name','number','cabinet','date_purchase','description','provider_id','status'])
            ->where('organization_id', $user->organization_id)->get();

        $mass = [];
        foreach ($technics as $technic) {
            $mass[] = [
                'id' => $technic->id,
                'name' => $technic->name,
                'number' => $technic->number,
                'cabinet' => $technic->cabinet,
                'date' => $technic->date_purchase,
                'description' => $technic->description,
                'provider' => $technic->provider->name,
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
            abort(400, 'Хм. Данная ошибка не должна была возникнуть не прикаких обстоятельствах');
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
}
