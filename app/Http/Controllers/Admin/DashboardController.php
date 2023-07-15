<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index() {
        if(auth()->guard('admin')->check()) {
            $products = Product::all();
            return view('admin.index', compact('products'));
        } else {
            return redirect()->intended('/');
        }
    }
}
