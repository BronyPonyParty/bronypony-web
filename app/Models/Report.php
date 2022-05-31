<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function technic() {
        return $this->hasOne(Technic::class, 'id', 'technic_id');
    }
}
