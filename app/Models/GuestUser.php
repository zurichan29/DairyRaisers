<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestUser extends Model
{
    use HasFactory;

    // protected $guarded = [];
    // protected $table = 'guest_users';

    // public function guest_cart()
    // {
    //     return $this->hasMany(GuestCart::class);
    // }

    // public function guest_order()
    // {
    //     return $this->hasMany(GuestOrder::class);
    // }
}
