<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestOrder extends Model
{
    use HasFactory;


    protected $guarded = [];
    protected $table = 'guest_order';

    public function guest_users()
    {
        return $this->belongsTo(GuestUser::class);
    }

    public function guest_cart()
    {
      return $this->hasMany(GuestCart::class);
    }
}
