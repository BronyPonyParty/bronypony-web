<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Technic extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function movingTechnic() {
        return $this->hasOne(MovingTechnic::class, 'id', 'technic_id');
    }


    protected $hidden = [
        'organization_id'
    ];
}
