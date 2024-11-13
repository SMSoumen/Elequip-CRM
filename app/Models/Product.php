<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['product_category_id', 'product_sub_category_id', 'product_name', 'product_code', 'product_price', 'measuring_unit_id', 'brand_id', 'product_tech_spec', 'product_marketing_spec', 'status'];
}
