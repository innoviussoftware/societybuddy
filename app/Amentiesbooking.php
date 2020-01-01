<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Amentiesbooking extends Model
{
    protected $table = 'amenties_booking';
    
    protected $fillable = [
        'amenties_id','user_id','date','start_time','end_time','description','apporve'
    ];

    public function amenties(){
        return $this->belongsTo('App\Amenties','amenties_id');
    }
}
