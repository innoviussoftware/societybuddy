<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


class Society extends Model
{
    protected $fillable = [
        'area_id', 'name', 'address', 'document', 'email', 'contact', 'logo','lat','lng'
    ];

    // public function getDocumentAttribute($value): string {
    //     return $value ? env('APP_URL_WITHOUT_PUBLIC').Storage::url('app/'.$value) : "";
    // }
    //
    // public function getLogoAttribute($value): string {
    //     return $value ? env('APP_URL_WITHOUT_PUBLIC').Storage::url('app/'.$value) : "";
    // }

    public function getFullLogoPathAttribute(){
          return $this->logo ? env('APP_URL_WITHOUT_PUBLIC').Storage::url('app/'. $this->logo) : "";
    }
    public function getFullDocumentPathAttribute(){
          return $this->document ? env('APP_URL_WITHOUT_PUBLIC').Storage::url('app/'. $this->document) : "";
    }

    public function area(){
        return $this->belongsTo('App\Area','area_id');
    }

    public function notice(){
        return $this->hasMany('App\Notice','id');
    }

    public function visitor(){
        return $this->hasMany('App\Visitor','id');
    }


}
