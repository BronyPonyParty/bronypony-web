<?php

namespace App\Http\Controllers;

use App\Models\MovingTechnic;
use App\Models\Premise;
use App\Models\Provider;
use App\Models\Repair;
use App\Models\Report;
use App\Models\Technic;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as AuthFacade;

class TechnicController extends Controller
{
    public function getTechnicList() {
        $user = AuthFacade::user();
        $technics = Technic::whereOrganizationId($user->organization_id)->get();


        $technicProviderIds = [];
        foreach ($technics as $technic) {
            if (!in_array($technic->provider_id, $technicProviderIds)) $technicProviderIds[] = $technic->provider_id;
        }

        $providers = Provider::select(['id', 'name'])->whereIn('id', $technicProviderIds)->get();

        $providerNames = [];
        foreach ($providers as $provider) $providerNames[$provider->id] = $provider->name;

        $mass = [];
        foreach ($technics as $technic) {
            $mass[] = [
                'id' => $technic->id,
                'name' => $technic->name,
                'number' => $technic->number,
                'date' => $technic->date_purchase,
                'description' => $technic->description,
                'provider' => $providerNames[$technic->provider_id],
                'status' => $technic->status
            ];
        }

        return $mass;
    }

    public function getTechnicInfo(Request $request) {
        $authUser = AuthFacade::user();
        $technic_id = $request->get('technic_id');

        $movingTechnics = MovingTechnic::whereTechnicId($technic_id)->get();

        $userIds = [];
        $premiseIds = [];
        foreach ($movingTechnics as $movingTechnic) {
            if (!in_array($movingTechnic->user_id, $userIds)) $userIds[] = $movingTechnic->user_id;
            if (!in_array($movingTechnic->premise_id, $premiseIds)) $premiseIds[] = $movingTechnic->premise_id;
        }

        $premises = Premise::whereOrganizationId($authUser->organization_id)->whereIn('id', $premiseIds)->get();
        $users = User::whereOrganizationId($authUser->organization_id)->whereIn('id', $userIds)->get();

        $premiseNumbers = [];
        $premiseFloors = [];
        foreach ($premises as $premise) {
            $premiseNumbers[$premise->id] = $premise->number < 10 ? 0 . $premise->number : $premise->number;
            $premiseFloors[$premise->id] = $premise->floor;
        }

        $userNames = [];
        foreach ($users as $user) $userNames[$user->id] = $user->lastname . ' ' . $user->firstname;

        $movingMass = [];
        for ($i = 0; $i < count($movingTechnics); $i++) {
            $movingMass[] = [
                'id'   => $movingTechnics[$i]->id,
                'user' => $userNames[$movingTechnics[$i]->user_id],
                'number'   =>  $premiseFloors[$movingTechnics[$i]->premise_id] . $premiseNumbers[$movingTechnics[$i]->premise_id],
                'date' => $movingTechnics[$i]->date
            ];
        }


        $reports = Report::whereTechnicId($technic_id)->where('status', 4)->get(); // Отобрать только готовые ремонты

        $reportIds = [];
        $userIds = [];
        foreach ($reports as $report) {
            $reportIds[] = $report->id;
            if (!in_array($report->user_id, $userIds)) $userIds[] = $report->user_id;
        }

        $repairs = Repair::whereIn('report_id', $reportIds)->get();

        foreach ($repairs as $repair) {
            if (!in_array($repair->repairman_id, $userIds)) $userIds[] = $repair->repairman_id;
        };

        $users = User::whereOrganizationId($authUser->organization_id)->whereIn('id', $userIds)->get();

        $userNames = [];
        foreach ($users as $user) $userNames[$user->id] = $user->lastname . ' ' . $user->firstname;

        $reportRow = [];
        foreach ($reports as $report) $reportRow[$report->id] = $report;

        $repairMass = [];
        foreach ($repairs as $repair) {
            $repairMass[] = [
                'id' => $repair->id,
                'user' => $userNames[$reportRow[$repair->id]->user_id],
                'repairman' => $userNames[$repair->repairman_id],
                'userDescription' => $reportRow[$repair->id]->description,
                'repairmanDescription' => $repair->description,
                'startDate' => $reportRow[$repair->id]->create_date,
                'endDate' => $reportRow[$repair->id]->complete_date
            ];
        }

        return [$movingMass, $repairMass];
    }
}
