<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','role','gst_no',
        'phone',
        'password',
        'zipcode',
        'address',
        'address_line_1',
        'address_line_2',
        'invoice_title'
    ];


    public function setPasswordAttribute($pass){

        return $this->attributes['password'] = Hash::needsRehash($pass) ? Hash::make($pass) : $pass;
        
        }
        
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function reservation() {
        return $this->hasMany(Reservation::class,'guest_id','id');
    }
}
