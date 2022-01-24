<?php

namespace App\Models;

use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{    use HasApiTokens, Notifiable ;
    use HasFactory;
    use CanResetPassword;
    use LaratrustUserTrait;

    protected $guard ='admin';

    protected $fillable=['name','email','image','password'];

    protected $appends=['image_path'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getImagePathAttribute()
    {
        return asset('/upload/admins/' . $this->image);
    }
}
