<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'name',
        'amount',
        'payment_date',
        'status',
        'user_id'
    ];
}
