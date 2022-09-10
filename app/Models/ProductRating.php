<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductRating extends Model
{
    protected $table = 'product_ratings';

    protected $fillable = ['product_id', 'rating'];

}
