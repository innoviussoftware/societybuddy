<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
    //
    protected $table = 'reveiws';

    protected $fillable = [
     	'user_id','helper_id','ratings','comment'
    ];

}
