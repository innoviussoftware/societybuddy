<?php namespace App;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
  public static function memberRoles(){
    return self::where('name','!=','admin')->where('name','!=','sub_admin')->where('name','!=','society_admin')->get();
  }
}
