<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Order extends Model
{
  use HasFactory;

  protected $table = 'orders';

  protected $casts = [
    'items' => 'array',
  ];
  protected $fillable = [
    'name', 'mobile_number', 'email', 'items', 'store_name',
    'customer_id', 'customer_type', 'order_number', 'grand_total', 'user_address',
    'remarks', 'comments', 'delivery_option', 'payment_method',
    'reference_number', 'payment_receipt', 'status'
  ];

  // Add a mapping for customer types
  protected static $customerTypeMap = [
    'online_shopper' => OnlineShopper::class,
    'retailer' => Retailer::class,
    'guest' => GuestUser::class,
  ];

  // Add a mapping for customer types using a custom morph map
  protected static function boot()
  {
    parent::boot();

    // Define the morph map
    Relation::morphMap([
      'online_shopper' => OnlineShopper::class,
      'retailer' => Retailer::class,
      'guest' => GuestUser::class,
    ]);
  }

  // Define the relationship with Retailer model for retailers
  public function customer()
  {
    return $this->morphTo();
  }

  public function product()
  {
    return $this->belongsTo(Product::class);
  }

  public function cart()
  {
    return $this->hasMany(Cart::class);
  }

  public function payment_reciept()
  {
    return $this->hasMany(PaymentReciept::class, 'order_id');
  }
}
