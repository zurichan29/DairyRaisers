<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuffaloSales extends Model
{
    use HasFactory;

    protected $fillable = ['buyer_name', 'buyer_address', 'mobile_number', 'total_quantity', 'details', 'grand_total'];

    protected $table = 'buffalo_sales';
}
