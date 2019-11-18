<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Guard extends Model
{
	use HasApiTokens,Notifiable;
	
    protected $fillable = [
        'name', 'society_id', 'phone', 'gender', 'profile_pic', 'login_pin'
    ];

    public function guards(){
        return $this->belongsTo('App\Society','society_id');
    }

    public static function getProfilePic($value): string {
        return $value ? env('APP_URL_WITHOUT_PUBLIC').Storage::url('app/'.$value) : "";
    }
   
   	public function visitor(){
        return $this->hasMany('App\Visitor','id');
    }

    
}
