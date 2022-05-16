<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Technic extends Model
{
    use HasFactory;

    public function provider() {
        return $this->hasOne(Provider::class, 'id', 'provider_id');
    }


    protected $hidden = [
        'organization_id'
    ];
}
