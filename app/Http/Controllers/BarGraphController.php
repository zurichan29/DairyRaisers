<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class BarGraphController extends Controller
{
    //
    public function showMap()
    {
        $milkStock = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September'];
        $milkStock = ['10', '5', '100', '90', '50', '30', '15', '11', '8'];
        return view('showMap',['labels' => $milkStock, 'prices' => $milkStock]);
    }
}
