<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Maintence extends Model
{
    //

    protected $table = 'maintence';

    protected $fillable = [
      'user_id', 'society_id', 'building_id', 'type', 'maintence_amount', 'tenant_amount','payment','penalty'
    ];

}
