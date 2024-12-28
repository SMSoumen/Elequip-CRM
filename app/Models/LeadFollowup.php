<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeadFollowup extends Model
{
    protected $fillable = ['id','lead_id','followup_next_date','followup_remarks','followup_type','admin_id','status','created_at','updated_at'];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }


}
