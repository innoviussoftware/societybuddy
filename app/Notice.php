<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $table = 'notice';

    protected $fillable = [
        'society_id','building_id','user_id','title','description','view_till'
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
