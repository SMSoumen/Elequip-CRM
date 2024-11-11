<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MeasuringUnit extends Model
{
    use HasFactory;
    protected $fillable = ['unit_type','status','created_at','updated_at'];
}
