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
 * App\Models\MovingTechnic
 *
 * @property int $id
 * @property int $user_id
 * @property int $technic_id
 * @property int $premise_id
 * @property int $date
 * @property-read \App\Models\Premise|null $premise
 * @property-read \App\Models\Technic|null $technic
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|MovingTechnic newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MovingTechnic newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MovingTechnic query()
 * @method static \Illuminate\Database\Eloquent\Builder|MovingTechnic whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovingTechnic whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovingTechnic wherePremiseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovingTechnic whereTechnicId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovingTechnic whereUserId($value)
 */
	class MovingTechnic extends \Eloquent {}
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
 * @property string $name
 * @property string $address
 * @property string $phone_number
 * @property int $registration_date
 * @property int $status
 * @method static \Database\Factories\OrganizationFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Organization newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Organization query()
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereRegistrationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereStatus($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder|Premise newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Premise newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Premise query()
 * @method static \Illuminate\Database\Eloquent\Builder|Premise whereFloor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Premise whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Premise whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Premise whereOrganizationId($value)
 */
	class Premise extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Provider
 *
 * @property int $id
 * @property string $name
 * @property string $phone_number
 * @property string $address
 * @property int $status
 * @method static \Database\Factories\ProviderFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Provider newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Provider newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Provider query()
 * @method static \Illuminate\Database\Eloquent\Builder|Provider whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Provider whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Provider whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Provider wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Provider whereStatus($value)
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
 * @property string|null $description
 * @method static \Illuminate\Database\Eloquent\Builder|Repair newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Repair newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Repair query()
 * @method static \Illuminate\Database\Eloquent\Builder|Repair whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Repair whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Repair whereRepairmanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Repair whereReportId($value)
 */
	class Repair extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Report
 *
 * @property int $id
 * @property int $technic_id
 * @property int $user_id
 * @property string|null $description
 * @property int $create_date
 * @property int|null $complete_date
 * @property int $status
 * @method static \Illuminate\Database\Eloquent\Builder|Report newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Report newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Report query()
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereCompleteDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereCreateDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereTechnicId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereUserId($value)
 */
	class Report extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Session
 *
 * @property int $id
 * @property int $user_id
 * @property string $token
 * @property int $term
 * @property string $ip
 * @property int $removed
 * @method static \Illuminate\Database\Eloquent\Builder|Session newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Session newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Session query()
 * @method static \Illuminate\Database\Eloquent\Builder|Session whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Session whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Session whereRemoved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Session whereTerm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Session whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Session whereUserId($value)
 */
	class Session extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Technic
 *
 * @property int $id
 * @property string $name
 * @property int $number
 * @property int $date_purchase
 * @property string|null $description
 * @property int $provider_id
 * @property int $organization_id
 * @property int $status
 * @property-read \App\Models\Provider|null $provider
 * @method static \Database\Factories\TechnicFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Technic newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Technic newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Technic query()
 * @method static \Illuminate\Database\Eloquent\Builder|Technic whereDatePurchase($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Technic whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Technic whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Technic whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Technic whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Technic whereOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Technic whereProviderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Technic whereStatus($value)
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
 * @property int $status
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLogin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereMail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereMiddlename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereStatus($value)
 */
	class User extends \Eloquent {}
}

