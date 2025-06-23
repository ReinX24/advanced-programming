<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'student_id',
        'title',
        'appointment_date',
        'appointment_time',
        'status',
        'remarks',
    ];
}
