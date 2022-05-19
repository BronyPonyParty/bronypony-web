<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovingTechnic extends Model
{
    use HasFactory;

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function technic() {
        return $this->hasOne(Technic::class, 'id', 'technic_id');
    }

    public function premise() {
        return $this->hasOne(Premise::class, 'id', 'premise_id');
    }
}
