<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
      'user_id',
      'order_id',
      'grand_total',
      'payment_method',
      'user_address',
      'remarks',
      'delivery_status'  
    ];

    protected $table = 'order';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cart()
    {
      return $this->hasMany(Cart::class);
    }
}
