<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LeadStage extends Model
{
    use HasFactory;
    protected $fillable = ['stage_name','stage_slug','status','created_at','updated_at'];
}
