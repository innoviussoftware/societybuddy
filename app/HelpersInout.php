<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HelpersInout extends Model
{
    //
    protected $table = 'helpers_inout';

    protected $fillable = [
      'society_id', 'guard_id', 'helpers_id', 'intime', 'outtime', 'flag','soft_delete'
    ];

    
}
