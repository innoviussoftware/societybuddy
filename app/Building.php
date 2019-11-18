<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


class Building extends Model
{
    protected $fillable = [
        'society_id', 'name'
    ];
    public $timestamps = false;

    public function society(){
        return $this->belongsTo('App\Society','society_id');
    }

    public function flats(){
        return $this->hasMany('App\Flat','building_id');
    }

    public function notice(){
        return $this->hasMany('App\Notice','id');
    }

    public function visitor(){
        return $this->hasMany('App\Visitor','id');
    }

   


}
