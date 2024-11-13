<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSubCategory extends Model
{
    protected $fillable = ['product_category_id', 'product_subcat_name', 'product_subcat_slug', 'status'];
}
