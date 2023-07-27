<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MilkStock extends Model
{
    use HasFactory;

    protected $fillable = ['date_created', 'quantity'];
}
