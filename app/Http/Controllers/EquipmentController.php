<?php

namespace App\Http\Controllers;

use App\Models\Technic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as AuthFacade;

class EquipmentController extends Controller
{
    public function getEquipmentList() {
        $user = AuthFacade::user();
        $technics = Technic::whereOrganizationId($user->organization_id)->get();

        $mass = [];
        foreach ($technics as $technic) {
            $mass[] = [
                'id' => $technic->id,
                'name' => $technic->name,
                'number' => $technic->number,
                'date' => $technic->date_purchase,
                'description' => $technic->description,
                'provider' => $technic->provider->name,
                'status' => $technic->status
            ];
        }

        return $mass;
    }

    public function getEquipmentInfo(Request $request) {
        return $request->get('technic_id');
    }
}
