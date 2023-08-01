<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlineShopper extends Model
{
    use HasFactory;

    protected $table = 'online_shoppers';

    public function orders()
    {
        return $this->morphMany(Order::class, 'customer');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
