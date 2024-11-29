<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderAndDelivery extends Model
{
    protected $fillable = ['purchase_order_id','lead_id','quotation_id','product_id','order_product_name','order_product_code','measuring_unit','order_product_qty','order_product_spec','order_product_unit_price','order_product_total_price','order_product_delivery_date','status','created_at','updated_at'];
}
