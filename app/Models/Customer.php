<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = ['contact_person','designation','mobile','phone','email','email2','company_name','address','status','created_at','updated_at'];

}
