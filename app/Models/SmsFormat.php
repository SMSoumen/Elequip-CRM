<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SmsFormat extends Model
{
    use HasFactory;
    protected $fillable = ['template_name','template_id','template_format','status','created_at','updated_at'];
}
