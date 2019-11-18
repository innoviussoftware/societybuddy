<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Circular extends Model
{
    //
    protected $table = 'circular';
    
    protected $fillable = [
        'society_id','building_id','member_id','title','description','pdffile'
    ];
    
     public function society(){
        return $this->belongsTo('App\Society','society_id');
    }

    public function building(){
        return $this->belongsTo('App\Building','building_id');
    }

    public function member(){
        return $this->belongsTo('App\Member','member_id');
    }
}
