<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    //
    protected $table = 'settings';

    protected $fillable = [
      'user_id', 'receiver_id', 'event', 'notice', 'circular', 'contact_details','family_details',
    ];

    public function societys(){
        return $this->belongsTo('App\Society','society_id');
    }

	public function users(){
        return $this->belongsTo('App\User','user_id');
    }   

    public function members(){
        return $this->belongsTo('App\Member','id','user_id');
    }  
}
