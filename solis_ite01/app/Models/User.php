<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_photo_path'
    ];

    protected $appends  = ['created_date', 'display_photo', 'registered_date'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected function getCreatedDateAttribute()
    {
        return Carbon::parse($this->created_at)->format('F d, Y h:i A (T)');
    }

    public function profilePhotoUrl()
    {
        return $this->profile_photo_path
            ? Storage::url($this->profile_photo_path)
            : asset('images/default_profile.png');
    }

    public function getDisplayPhotoAttribute()
    {
        return $this->profile_photo_path
            ? Storage::url($this->profile_photo_path)
            : asset('images/default_profile.png');
    }

    public function getRegisteredDateAttribute()
    {
        return Carbon::parse($this->created_at)->format('F Y');
    }
}
