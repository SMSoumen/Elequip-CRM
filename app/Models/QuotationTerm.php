<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuotationTerm extends Model
{
    protected $fillable = ['id','lead_id','quotation_id','term_is_latest','term_discount','term_tax','term_inspection','term_price','term_dispatch','term_payment','term_warranty','term_validity','term_forwarding','term_note_1','term_note_2','created_at','updated_at'];

}
