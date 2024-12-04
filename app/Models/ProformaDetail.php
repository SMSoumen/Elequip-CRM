<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProformaDetail extends Model
{
    protected $fillable = ['proforma_invoice_id', 'product_id', 'proforma_product_spec', 'proforma_product_qty','proforma_product_price','created_at','updated_at'];
}
