<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DomesticHelpers extends Model
{
    
    protected $table = 'domestic_helpers';

    protected $fillable = [
     		'name','pin','type_id','member_id','mobile','document','gender','status','society_id','photos'
    ];

    public function member(){
        return $this->hasMany('App\Member','user_id');
    }

    function average_rating() {

        return $this->hasMany('App\Reviews', 'helper_id')
                    ->selectRaw('helper_id,AVG(ratings) AS average_rating')
                    ->groupBy('helper_id');
    }

    public function helperslist()
    {
         return $this->hasone('App\Inouts','request_id')->latest();
    }

    public function types()
    {
         return $this->belongsTo('App\ServiceTypes','id');
    }

}
