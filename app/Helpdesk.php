<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Helpdesk extends Model
{
    //
    protected $table = 'helpdesk';

    protected $fillable = [
      'societyName1', 'societyPhone1', 'societyName2', 'societyPhone2', 'fire', 'hostipalName','hostipalPhone','ambulance','society_id'
    ];

}
