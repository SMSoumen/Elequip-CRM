<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadDetail extends Model
{
    protected $fillable = ['lead_id','product_id','lead_product_name','lead_product_code','lead_product_qty','lead_product_price','lead_product_tech_spec','lead_product_m_spec','lead_product_unit','status','created_at','updated_at'];

}
