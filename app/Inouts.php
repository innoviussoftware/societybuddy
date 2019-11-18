<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inouts extends Model
{
    //
    protected $table = 'inoutlists';

    protected $fillable = [
      'guard_id', 'society_id', 'request_id', 'intime', 'outtime', 'flag','soft_delete'
    ];

    public function societys(){
        return $this->belongsTo('App\Society','society_id');
    }

	public function users(){
        return $this->belongsTo('App\User','user_id');
    }    

    public function visitorlist()
    {
         return $this->belongsTo('App\Visitor','request_id');
    }

    public function invitelist()
    {
         return $this->belongsTo('App\InviteGuest','request_id');
    }

    

}
