<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocietySettings extends Model
{
    //
    protected $table = 'society_settings';

    protected $fillable = [
      'society_id', 'module_name', 'flag'
    ];
}
