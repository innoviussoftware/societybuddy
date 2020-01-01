<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Amenties extends Model
{
    protected $table = 'amenties';
    
    protected $fillable = [
        'society_id','user_id','name','address','images','booking_date','apporve','is_book','notes','amount'
    ];

    public function society(){
        return $this->belongsTo('App\Society','society_id');
    }

    public function member(){
        return $this->belongsTo('App\Member','user_id');
    }
}
