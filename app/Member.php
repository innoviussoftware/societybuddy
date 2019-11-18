<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


class Member extends Model
{
    protected $fillable = [
        'user_id','society_id','building_id','flat_id','flatType','city_id','area_id','gender','profession','prefession_detail', 'flattype', 'relation', 'bloodgroup','family_user_id','occupancy'
    ];

    public $timestamps = false;

    public function user(){
        return $this->belongsTo('App\User','user_id');
    }

    public function building(){
        return $this->belongsTo('App\Building','building_id');
    }

    public function flat(){
        return $this->belongsTo('App\Flat','flat_id');
    }

    public function notice(){
        return $this->hasMany('App\Notice','id');
    }

    public function settings(){
        return $this->hasMany('App\Settings','user_id','user_id');
    }

    public function family_user(){
        return $this->belongsTo('App\User','family_user_id');
    }

    public function vehicle(){
        return $this->hasMany('App\Vehicle','user_id','user_id');
    }

    public function familyvehicle(){
        return $this->hasMany('App\Vehicle','user_id','family_user_id');
    }
}
