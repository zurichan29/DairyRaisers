<?php

namespace App\Http\Controllers\Admin;

use App\Models\MilkStock;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MilkStockController extends Controller
{
    //
    public function index()
    {
        // Your logic here
        if(auth()->guard('admin')->check()) {
            return view('admin.buffalos.index');
        } else {
            return redirect()->back();
        }
    }
    
    public function submitMilkStock(Request $request) {
        if (auth()->guard('admin')->check()) {
            $validatedData = $request->validate([
                'date_created' => 'required|date',
                'quantity' => 'required|integer',
            ]);
    
            // Create and save the MilkStock model instance
            $milkStock = new MilkStock();
            $milkStock->date_created = $request->date_created;
            $milkStock->quantity = $request->quantity;
            $milkStock->save();
    
            // Optionally, you can add a success message or redirect to another page
            return redirect()->back()->with('success', 'Milk data submitted successfully!');
        }
    }
    
}