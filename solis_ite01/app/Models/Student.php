<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table = "students";

    protected $fillable = [
        'fname',
        'lname',
        'email',
        'contact_number',
        'gender',
        'birthdate',
        'complete_address',
        'bio'
    ];

    protected function getCreatedDateAttribute()
    {
        return Carbon::parse($this->created_at)->format('F d, Y h:i A (T)');
    }
}
