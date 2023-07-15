<?php

namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Cart;
use App\Models\GuestUser;
use App\Models\GuestCart;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    //

    public function index(Request $request)
    {      
        return view('client.index');
    }

    public function order()
    {
        $data = Product::all();
        return view('client.order', ['order' => $data]);
    }

    public function about()
    {
        return view('client.others.about');
    }

    public function contact()
    {
        return view('client.others.contact');
    }

    public function faqs()
    {
        return view('client.others.faqs');
    }

    public function terms()
    {
        return view('client.others.terms');
    }

    

    /* -------------------------------------------------------------------------------- */

    public function checkout()
    {

        $data = Product::all();

        return view('client.checkout', ['checkout' => $data]);
    }

    public function payment()
    {

        return view('client.payment');
    }

    public function detail()
    {

        $data = Product::all();

        return view('user-page.detail', ['detail' => $data]);
    }
}
