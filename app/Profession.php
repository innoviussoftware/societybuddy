<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profession extends Model
{
    //
    protected $table = 'profession';

    protected $fillable = [
        'id','name'
    ];

}
