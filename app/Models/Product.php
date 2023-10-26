<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'img', 'variants_id', 'price', 'stocks', 'description', 'status'];
    protected $table = 'product';

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function variant() {
        return $this->belongsTo(Variants::class, 'variants_id');
    }

    public function stocks()
    {
        return $this->hasMany(ProductStock::class)->orderBy('date_created', 'asc');
    }

    public function productStocks()
    {
        return $this->hasMany(ProductStock::class);
    }
    
}
