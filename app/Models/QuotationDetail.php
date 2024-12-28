<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuotationDetail extends Model
{
    protected $fillable = ['id','quotation_id','product_id','quot_product_qty','quot_product_unit','quot_product_unit_price','quot_product_total_price','quot_product_discount','quot_product_discount_amount','quot_product_name','quot_product_code','quot_product_tech_spec','quot_product_m_spec','created_at','updated_at'];

}
