<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function cart(){
        return $this->belongsTo(Cart::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function offer(){
        return $this->belongsTo(Offer::class);
    }

    public function reviews(){
        return $this->hasMany(Review::class);
    }

    public function relatedProducts()
    {
        return $this->hasMany(Product::class, 'category_id', 'category_id');
    }
}
