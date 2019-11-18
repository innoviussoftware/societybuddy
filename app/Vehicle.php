<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


class Vehicle extends Model
{
    protected $fillable = [
        'user_id','type','number'
    ];
    public $timestamps = false;

    public function user(){
        return $this->belongsTo('App\User','user_id');
    }

}
