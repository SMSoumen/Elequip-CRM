<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProformaInvoice extends Model
{
    protected $fillable = ['id','lead_id', 'purchase_order_id', 'proforma_discount', 'proforma_gst_type','proforma_remarks','created_by','updated_by','created_at','updated_at'];

    public function proforma_details() : HasMany {
        return $this->hasMany(ProformaDetail::class);
    }

}
