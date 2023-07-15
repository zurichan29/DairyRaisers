<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'img', 'variant', 'price'];
    protected $table = 'product';

    public function carts()
    {
        return $this->hasMany(Cart::class);
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
