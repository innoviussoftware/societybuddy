<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $table = 'products';
    
    protected $fillable = [
        'user_id', 'category_id','title','price','description','flag','quality'
    ];

    public function user(){
        return $this->belongsTo('App\User','user_id');
    }

    public function categories(){
        return $this->belongsTo('App\Categories','category_id');
    }

    public function productsimages()
    {
    	return $this->hasMany('App\ProductsImages','product_id','id');
    }
}
