<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = ['id','customer_name','designation','mobile','phone','email','email2','company_id','address','status','created_at','updated_at'];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

}
