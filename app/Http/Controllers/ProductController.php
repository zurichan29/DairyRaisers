<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    protected $cart;
    public function __construct()
    {
        $this->cart = new Cart();
    }
    public function index()
    {
        return view('client.page.index');
    }

    public function product()
    {

        $data = Product::all();

        return view('user-page.product', ['product' => $data]);
    }

    public function view(Request $request, $id)
    {
        $data = Product::find($id);
        if ($data) {
            return view('user-page.view-product', ['product' => $data, 'mysession' => $request->session()->get('product_id')]);
        } else {
            return null;
        }
    }

    public function add(Request $request, $productId)
    {   
        $productId = (int)$productId;
        $product = Product::find($productId);
        $quantity = (int)$request->input('quantity', 1);
        $all_cart = Session::get('product');

        if ($product) {

            $item_exists = false;

            if ($all_cart) {

                foreach ($all_cart as $key => $value) {
                    if ($value['productId'] === $productId) {
                        $new_quantity = $quantity + $value['quantity'];
                        session::put('product.' . $key . '.quantity', $new_quantity);
                        $item_exists = true;
                        break;
                    }
                }

            }
            if ($item_exists == false) {
                Session::push('product', ['productId' => $productId, 'quantity' => $quantity]);
            }

            Session::flash('message', 'Data stored successfully.');
            return redirect()->back();
        } else {
            Session::flash('error', 'Something went wrong.');
            return redirect()->back();
        }
    }

    public function order()
    {

        $data = Product::all();

        return view('user-page.order', ['order' => $data]);
    }

    public function about()
    {

        return view('user-page.about');
    }

    public function contact()
    {

        return view('user-page.contact');
    }

    public function faqs()
    {

        return view('user-page.faqs');
    }

    public function cart()
    {

        $data = Product::all();

        return view('user-page.cart', ['cart' => $data]);
    }

    public function checkout()
    {

        $data = Product::all();

        return view('user-page.checkout', ['checkout' => $data]);
    }

    public function payment()
    {

        return view('user-page.payment');
    }

    public function terms()
    {

        return view('user-page.terms');
    }

    public function login()
    {

        return view('user-page.login');
    }

    public function register()
    {

        return view('user-page.register');
    }

    public function detail()
    {

        $data = Product::all();

        return view('user-page.detail', ['detail' => $data]);
    }
}
