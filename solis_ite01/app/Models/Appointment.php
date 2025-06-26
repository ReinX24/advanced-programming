<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'title',
        'appointment_date',
        'appointment_time',
        'status',
        'remarks',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
