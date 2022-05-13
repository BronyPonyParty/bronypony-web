<?php

namespace App\Http\Controllers;

use App\Models\Technic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as AuthFacade;

class EquipmentController extends Controller
{
    public function getEquipmentData() {
        $user = AuthFacade::user();
        $technics = Technic::whereOrganizationId($user->organization_id)->get();

        $mass = [];
        foreach ($technics as $technic) {
            $mass[] = [
                'name' => $technic->name,
                'number' => $technic->number,
                'date' => $technic->date_purchase,
                'description' => $technic->description,
                'organization' => $technic->provider->organization_name,
                'status' => $technic->status
            ];
        };
        return $mass;
    }
}
