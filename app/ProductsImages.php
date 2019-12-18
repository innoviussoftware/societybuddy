<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductsImages extends Model
{
    protected $table = 'products_images';
    
    protected $fillable = [
        'product_id', 'image'
    ];

    public function product(){
        return $this->belongsTo('App\Products','product_id');
    }

}
