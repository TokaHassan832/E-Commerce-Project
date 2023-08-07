<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded=[];


    public function scopeFilter($query , array $filters)
    {
        $query->when($filters['search'] ?? false, fn($query, $search) =>
        $query->where('name', 'like', '%' . request('search') . '%')
            ->orwhere('description', 'like', '%' . request('search') . '%')
            ->orwhere('details', 'like', '%' . request('search') . '%'));


        $query->when($filters['category'] ?? false , fn($query,$category) =>
        $query
            ->whereExists(fn($query)=>
            $query->from('categories')
                ->whereColumn('categories.id','products.category_id')
                ->where('categories.slug',$category))
        );

    }

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
