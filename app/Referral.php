<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    //
    protected $table = 'referral';

    protected $fillable = [
      'user_id', 'society_id', 'contact','society_name'
    ];

     public function user(){
        return $this->belongsTo('App\User','user_id');
    }

}
