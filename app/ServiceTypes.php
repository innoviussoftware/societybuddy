<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceTypes extends Model
{
    
    protected $table = 'servicetypes';

    protected $fillable = [
      'name'
    ];

}
