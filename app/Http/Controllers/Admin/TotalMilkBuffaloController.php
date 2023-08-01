<?php

namespace App\Http\Controllers\Admin;

use App\Models\MilkStock;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TotalMilkBuffaloController extends Controller
{
    //
    public function totalQuantity()
    {
        $total = MilkStock::sum('quantity');
    }
}
