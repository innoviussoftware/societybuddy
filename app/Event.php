<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    //
    protected $table = 'events';
    
    protected $fillable = [
        'society_id','building_id','member_id','event_type','title','description','event_start_date','event_start_time,','event_end_date','event_end_time','event_attachment'
    ];

     public function society(){
        return $this->belongsTo('App\Society','society_id');
    }

    public function building(){
        return $this->belongsTo('App\Building','building_id');
    }

    public function member(){
        return $this->belongsTo('App\Member','member_id');
    }
}
