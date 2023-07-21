<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
}
