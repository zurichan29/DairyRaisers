<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function pieChart()
    {
        // Your pie chart logic here
        return view('admin.pie_chart');
    }

    public function barChart()
    {
        // Your bar chart logic here
        return view('admin.bar_chart');
    }

    public function dashboard() {

        return view('admin.admin_dashboard');
    }

    public function customers() {

        return view('admin.customers');
    }

    public function inventory() {

        $data= Product::all();

        return view('admin.inventory',['inventory'=>$data]);
    }

    public function addProducts() {

        $data= Product::all();

        return view('admin.add_products',['addProducts'=>$data]);
    }
}
