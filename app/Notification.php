<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    //
    protected $table = 'notifications';

    protected $fillable = [
      'text', 'user_id', 'type', 'isread'
    ];

     public function user(){
        return $this->belongsTo('App\User','user_id');
    }
}
