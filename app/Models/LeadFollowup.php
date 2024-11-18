<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadFollowup extends Model
{
    protected $fillable = ['lead_id','followup_next_date','followup_remarks','followup_type','admin_id','status','created_at','updated_at'];

}
