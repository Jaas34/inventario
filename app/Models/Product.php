<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['sku', 'name', 'description', 'price', 'quantity', 'stock'];

    protected $appends = ['categories'];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_products', 'product_id', 'category_id');
    }

    public function getCategoriesAttribute()
    {
        $categories = $this->categories()->orderBy('name')->get()->pluck('name')->toArray();
        return implode(', ', $categories);
    }

}
