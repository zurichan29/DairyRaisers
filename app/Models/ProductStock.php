<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'stock', 'date_created', 'expiration_date'];
    protected $table = 'product_stocks';

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
