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
}
