<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = ['id','product_category_id', 'product_sub_category_id', 'product_name', 'product_code', 'product_price', 'measuring_unit_id', 'brand_id', 'product_tech_spec', 'product_marketing_spec', 'status'];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function sub_category(): BelongsTo
    {
        return $this->belongsTo(ProductSubCategory::class, 'product_sub_category_id');
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(MeasuringUnit::class, 'measuring_unit_id');
    }

}
