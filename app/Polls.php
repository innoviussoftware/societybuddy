<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Polls extends Model
{
    protected $table = 'polls';
    
    protected $fillable = [
        'society_id', 'question','a1','a2','a3','a4','a1_userid','a2_userid','a3_userid','a4_userid','expires_on'
    ];
}
