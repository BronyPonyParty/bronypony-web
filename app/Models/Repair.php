<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repair extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function user() {
        return $this->hasOne(User::class, 'id', 'repairman_id');
    }

    public function report() {
        return $this->hasOne(Report::class, 'id', 'report_id');
    }
}
