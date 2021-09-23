<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPasswordNotification;

//comment implement to enable verification link
class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    protected $primaryKey = 'userIdx';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'email', 'companyIdx', 'businessName', 'role', 'jobTitle', 'password', 'passwordKey', 'forgottenPasswordToken', 'wallet', 'walletPrivateKey', 'buyerCheck', 'SellerCheck', 'userStatus','otp'
    ];

    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'forgottenPasswordToken',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function provider(){
        return $this->belongsTo('App\Models\Provider');
    }
    
    public function company(){
        return $this->belongsTo('App\Models\Company', 'companyIdx', 'companyIdx');
    }
    

    /**
     * Send the password reset notification.
     * @note: This override Authenticatable methodology
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token, $this->firstname, $this->email));
    }
}
