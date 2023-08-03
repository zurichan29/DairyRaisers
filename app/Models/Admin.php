<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    // ...

    protected $table = 'admin';
    protected $primaryKey = 'id'; // Set the primary key if different from 'id'

    protected $fillable = [
        'name', 'email', 'access', 'is_verified', 'verification_token', 'is_admin', 'status',
    ];

    protected static function boot()
    {
        parent::boot();

        // Automatically generate and set the unique ID before creating a new staff record
        static::creating(function ($staff) {
            $staff->unique_id = 'DR' . str_pad((static::max('id') + 1), 5, '0', STR_PAD_LEFT);
        });
    }
}
