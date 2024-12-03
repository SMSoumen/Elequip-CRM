<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lead extends Model
{
    protected $fillable = ['company_id','customer_id','lead_source_id','lead_category_id','lead_remarks','lead_estimate_closure_date','lead_total_amount','lead_stage_id','admin_id','lead_assigned_to','status','created_at','updated_at'];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

}
