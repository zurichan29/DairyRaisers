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

    public function test()
    {
        return view('test');
    }

    public function index(Request $request)
    {
        $deviceIdentifier = $request->input('device_identifier');
        //dd($deviceIdentifier);
        
        return view('client.page.index', ['identifier' => $deviceIdentifier]);
    }

    public function order()
    {
        $data = Product::all();
        return view('client.page.order', ['order' => $data]);
    }

    public function about(Request $request)
    {
        $deviceIdentifier = $request->input('device_identifier');

        return view('test');
        // return view('client.page.others.about', ['identifier' => $deviceIdentifier]);
    }

    public function contact()
    {
        return view('client.page.others.contact');
    }

    public function faqs()
    {
        return view('client.page.others.faqs');
    }

    public function terms()
    {
        return view('client.page.others.terms');
    }

    

    /* -------------------------------------------------------------------------------- */

    public function checkout()
    {

        $data = Product::all();

        return view('client.page.checkout', ['checkout' => $data]);
    }

    public function payment()
    {

        return view('client.page.payment');
    }

    public function detail()
    {

        $data = Product::all();

        return view('user-page.detail', ['detail' => $data]);
    }
}
