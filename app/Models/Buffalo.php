<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buffalo extends Model
{
    use HasFactory;
    
    protected $fillable = ['gender', 'age', 'price', 'total', 'quantity', ''];

    protected $table = 'buffalo';

}
