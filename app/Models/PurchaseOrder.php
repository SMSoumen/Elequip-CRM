<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $fillable = ['lead_id','quotation_id','po_refer_no','po_amount','po_gross_amount','po_net_amount','po_taxable','po_tax_percent','po_advance','po_remaining','po_document','po_remarks','po_order_no','po_order_date','po_et_bill_no','admin_id','created_at','updated_at'];

}
