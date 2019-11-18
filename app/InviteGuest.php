<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InviteGuest extends Model
{
    protected $table = 'inviteguest';

    protected $fillable = [
      'user_id', 'society_id', 'type', 'start_date', 'end_date', 'contact_name','contact_number','time','maxhour','soft_delete','flag'
    ];

    public function societys(){
        return $this->belongsTo('App\Society','society_id');
    }

	public function users(){
        return $this->belongsTo('App\User','user_id');
    }    

    public function guestlist()
    {
         return $this->hasone('App\Inouts','request_id')->latest();
    }

    

}
