<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProformaInvoice extends Model
{
    protected $fillable = ['lead_id', 'purchase_order_id', 'proforma_discount', 'proforma_gst_type','proforma_remarks','created_by','updated_by','created_at','updated_at'];

}
