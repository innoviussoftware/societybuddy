<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


class Familymember extends Model
{
    protected $fillable = 
    [
        'user_id','family_member_relation','family_member_name','family_member_phone','family_member_gender','family_member_dob','family_member_dob','family_member_status','family_member_photo'
    ];

    protected $table='members_family';

    public $timestamps = false;

}
