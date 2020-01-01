<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Maintence extends Model
{
    //

    protected $table = 'maintence';

    protected $fillable = [
       'society_id', 'building_id', 'payment_mode', 'maintence_amount', 'tenant_amount','monthlypayment_date','penalty','yearlypaymentdate'
    ];

}
