<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Support\Facades\Storage;



class User extends Authenticatable
{
    use HasApiTokens,Notifiable;
    use EntrustUserTrait; // add this trait to your user model

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone','society_id','fcm_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getFullImagePathAttribute(){
          return $this->image ? env('APP_URL_WITHOUT_PUBLIC').Storage::url('app/'. $this->image) : "";
    }
    
    public function member(){
        return $this->hasOne('App\Member','user_id');
    }

}
