<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buffalo extends Model
{
    use HasFactory;
    
    protected $fillable = ['gender', 'age', 'quantity', 'date_sold', 'buyers_name', 'buyers_address'];

    protected $table = 'buffalo';

}
