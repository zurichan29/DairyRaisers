<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Retailer extends Model
{
    use HasFactory;

    protected $fillable = ['first_name', 'last_name', 'mobile_number', 'region', 'province', 'municipality', 'barangay', 'street', 'zip_code', 'remarks'];

    protected $table = 'retailers';

    public function orders()
    {
        return $this->morphMany(Order::class, 'customer');
    }
}
