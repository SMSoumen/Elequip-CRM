<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class leadStage extends Model
{
    use HasFactory;
    // protected $table ='lead_sources';
    // protected $primaryKey="id";
    protected $fillable = ['stage_name','stage_slug','status','created_at','updated_at'];
}
