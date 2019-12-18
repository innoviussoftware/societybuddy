<?php

namespace App\Helpers\Notification;

use Illuminate\Support\Facades\DB;
use App\User;
use App\Member;

class FamilyMemberList
{
    public  static function getfamilyMemberList($userId)
    {
        $Member=Member::where('user_id',$userId)->first();

        if($Member->relation=='self')
        {

            $Member1=Member::where('family_user_id',$userId)->get();

            $id=[];

            foreach ($Member1 as $value) {
                $id[]=$value->user_id;
            }

            $Member2=Member::where('user_id',$userId)->get();

            $id2=[];

            foreach ($Member2 as $value) {
                $id2[]=$value->user_id;
            }

            $res = array_merge($id, $id2); 

            return $res;
        }
        else
        {
            $Member1=Member::where('family_user_id',$Member->family_user_id)->get();

            $id=[];

            foreach ($Member1 as $value) {
                $id[]=$value->user_id;
            }

            $Member2=Member::where('user_id',$Member->family_user_id)->get();

            $id2=[];

            foreach ($Member2 as $value) {
                $id2[]=$value->user_id;
            }

            $res = array_merge($id, $id2); 

            return $res;
        }
    }
    }
