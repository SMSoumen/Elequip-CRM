<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    protected $fillable = ['lead_id','quot_ref_no','quot_user_ref_no','quot_remarks','quot_version','qout_is_latest','quot_amount','admin_id','status','created_at','updated_at'];

}
