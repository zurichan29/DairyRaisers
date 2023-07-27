<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variants extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    protected $table = 'variants';

    public function products() {
        return $this->hasMany(Product::class, 'variants_id');
    }
}
