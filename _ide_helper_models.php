<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Movement_list
 *
 * @property int $id
 * @property int $premise_id
 * @property int $movement_technic_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Movement_list newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Movement_list newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Movement_list query()
 * @method static \Illuminate\Database\Eloquent\Builder|Movement_list whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movement_list whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movement_list whereMovementTechnicId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movement_list wherePremiseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movement_list whereUpdatedAt($value)
 */
	class Movement_list extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Movement_technic
 *
 * @property int $id
 * @property int $user_id
 * @property int $technic_id
 * @property int $date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Movement_technic newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Movement_technic newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Movement_technic query()
 * @method static \Illuminate\Database\Eloquent\Builder|Movement_technic whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movement_technic whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movement_technic whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movement_technic whereTechnicId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movement_technic whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movement_technic whereUserId($value)
 */
	class Movement_technic extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Order
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 */
	class Order extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Organization
 *
 * @property int $id
 * @property string $organization_name
 * @property string $address
 * @property string $phone_number
 * @property int $registration_date
 * @property string $state_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Organization newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Organization newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Organization query()
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereOrganizationName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereRegistrationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereStateName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereUpdatedAt($value)
 */
	class Organization extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Premise
 *
 * @property int $id
 * @property int $number
 * @property int $floor
 * @property int $organization_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Premise newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Premise newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Premise query()
 * @method static \Illuminate\Database\Eloquent\Builder|Premise whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Premise whereFloor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Premise whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Premise whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Premise whereOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Premise whereUpdatedAt($value)
 */
	class Premise extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Provider
 *
 * @property int $id
 * @property string $organization_name
 * @property string $phone_number
 * @property string $address
 * @property string $state_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Provider newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Provider newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Provider query()
 * @method static \Illuminate\Database\Eloquent\Builder|Provider whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Provider whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Provider whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Provider whereOrganizationName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Provider wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Provider whereStateName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Provider whereUpdatedAt($value)
 */
	class Provider extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Repair
 *
 * @property int $id
 * @property int $report_id
 * @property int $repairman_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Repair newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Repair newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Repair query()
 * @method static \Illuminate\Database\Eloquent\Builder|Repair whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Repair whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Repair whereRepairmanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Repair whereReportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Repair whereUpdatedAt($value)
 */
	class Repair extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Technic
 *
 * @property int $id
 * @property string $name
 * @property int $date_purchase
 * @property string|null $description
 * @property int $provider_id
 * @property int $organization_id
 * @property string $state_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Technic newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Technic newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Technic query()
 * @method static \Illuminate\Database\Eloquent\Builder|Technic whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Technic whereDatePurchase($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Technic whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Technic whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Technic whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Technic whereOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Technic whereProviderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Technic whereStateName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Technic whereUpdatedAt($value)
 */
	class Technic extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $lastname
 * @property string $firstname
 * @property string|null $middlename
 * @property string $login
 * @property string $password
 * @property string|null $phone_number
 * @property string $mail
 * @property string|null $avatar
 * @property int $organization_id
 * @property string $status_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLogin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereMail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereMiddlename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereStatusName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

