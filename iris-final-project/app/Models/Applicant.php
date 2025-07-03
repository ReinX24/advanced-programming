<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    /** @use HasFactory<\Database\Factories\ApplicantFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'age',
        'profile_photo',
        'curriculum_vitae',
        'working_experience',
        'educational_attainment',
        'medical',
        'status',
    ];
}
