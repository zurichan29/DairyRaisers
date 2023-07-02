<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'province',
        'city',
        'barangay',
        'street',
        'zip_code',
        'remarks',
        'label',
        'default'
    ];

    protected $table = 'user_address';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
