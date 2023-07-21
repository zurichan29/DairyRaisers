<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentReciept extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'user_id',
        'order_id',
        'reciept'
    ];

    protected $table = 'payment_reciept';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order() {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
