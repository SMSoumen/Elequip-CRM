<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class leadSources extends Model
{
    use HasFactory;
    protected $fillable = ['source_name','source_slug','status','created_at','updated_at'];
}
