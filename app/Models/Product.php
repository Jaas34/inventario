<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Product
 * @package App\Models
 */
class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['sku', 'name', 'description', 'price', 'quantity', 'stock'];

    protected $appends = ['categories', 'rating'];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    static $rules = [
        'sku'           => 'required',
        'name'          => 'required',
        'description'   => 'required',
        'price'         => 'required|numeric|min:0',
        'quantity'      => 'required|numeric|min:0',
        'stock'         => 'required',
        'category_id'   => 'required'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_products', 'product_id', 'category_id');
    }

    public function productRatings()
    {
        return $this->hasMany(ProductRating::class, 'product_id', 'id');
    }

    public function getCategoriesAttribute()
    {
        $categories = $this->categories()->orderBy('name')->get()->pluck('name')->toArray();
        return implode(', ', $categories);
    }

    public function getRatingAttribute()
    {
        $rating = $this->productRatings()->pluck('rating')->avg() ?? 0;
        return number_format($rating, 1, '.','');
    }

}
