<?php

namespace App\Http\Controllers\Admin;

use App\Models\Buffalo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BuffaloController extends Controller
{
    public function index()
    {
        // Your logic here
        if(auth()->guard('admin')->check()) {
            return view('admin.buffalos.index');
        } else {
            return redirect()->back();
        }
    }

    public function milk_stock()
    {
        // Add any necessary logic for managing buffalos
        $buffalo = Buffalo::all();
        return view('admin.buffalos.buffalo_stock.milk_stock', compact('buffalo'));
    }
}
