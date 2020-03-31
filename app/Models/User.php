<?php

namespace App\Models;
use App\Traits\HasRolesAndPermissions;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticable;
class User extends Authenticable
{
    //
    use Notifiable,HasRoleAndPermissions;
    /**
     * The attributes that are mass assignable
     * 
     * @var array
     */
    protected $fillable = [
        'name','user_email','password'
    ];
    /**
     * The attributes that should be hidden for arrays
     * 
     * @var array
     */
    protected $hidden = [
        'password','remember_token',
    ];
    
    /** 
     * The attributes that should be cast to native types
     * 
     * @var array
     * 
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
