<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestCart extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'guest_cart';

    public function guest_users()
    {
        return $this->belongsTo(GuestUser::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function guest_order()
    {
        return $this->belongsTo(GuestOrder::class);
    }
}
