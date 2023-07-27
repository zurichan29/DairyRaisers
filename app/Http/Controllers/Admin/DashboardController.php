<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use App\Events\OrderNotification;

class DashboardController extends Controller
{
    //
    public function index() {
        // Check if the admin is logged in
        if (auth()->guard('admin')->check()) {
            $products = Product::all();
            return view('admin.index', compact('products'));
        } else {
            // Redirect to the admin login page
            return redirect()->route('login.administrator');
        }
    }
    
    public function send_notifications() {

        $order = 'IM CHRISTIAN JAY';

        event(new OrderNotification($order));

        return redirect()->route('admin.dashboard');
    }
}
