<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    //
    protected $table = 'visitor';

    protected $fillable = [
        'society_id','building_id','guard_id','flat_id','name','photos','soft_delete'
    ];

    public function society(){
        return $this->belongsTo('App\Society','society_id');
    }

    public function building(){
        return $this->belongsTo('App\Building','building_id');
    }

     public function guards(){
        return $this->belongsTo('App\Guard','guard_id');
    }

    public function flats(){
        return $this->belongsTo('App\Flat','flat_id');
    }

    public function visitorlist()
    {
         return $this->hasone('App\Inouts','request_id')->latest();
    }

}
