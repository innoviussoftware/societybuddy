<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


class Flat extends Model
{
    protected $fillable = [
        'building_id', 'name'
    ];
    public $timestamps = false;

    public function building(){
        return $this->belongsTo('App\Building','building_id');
    }

    public function visitor(){
        return $this->hasMany('App\Visitor','id');
    }

}
