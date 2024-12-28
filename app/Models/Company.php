<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;
    protected $fillable = ['id','company_name','website','phone','city_id','email','gst','address','status','created_at','updated_at'];


    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class);
    }

}
