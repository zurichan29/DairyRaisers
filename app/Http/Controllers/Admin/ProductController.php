<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\Variants;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class ProductController extends Controller
{

    public function index()
    {
        if (auth()->guard('admin')->check()) {
            $products = Product::withSum('productStocks', 'stock')->get();
            $variants = Variants::all();
            return view('admin.products.index', compact('products', 'variants'));
        } else {
            throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
        }
    }

    public function create()
    {
        if (auth()->guard('admin')->check()) {
            $variants = Variants::all();
            return view('admin.products.inventory.create', compact('variants'));
        } else {
            throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
        }
    }

    public function show(Product $product)
    {
        if (auth()->guard('admin')->check()) {
            return view('admin.products.inventory.show', compact('product'));
        } else {
            throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
        }
    }

    public function edit(Product $product)
    {
        if (auth()->guard('admin')->check()) {
            $variants = Variants::all();
            return view('admin.products.inventory.edit', compact('product', 'variants'));
        } else {
            throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
        }
    }

    public function store(Request $request)
    {
        if (auth()->guard('admin')->check()) {

            $request->validate([
                'name' => 'required',
                'img' => 'required|image|mimes:jpeg,jpg,png|max:5120',
                'variant' => 'required|exists:variants,name',
                'price' => 'required|numeric',
            ]);

            // Handle the uploaded image
            if ($request->hasFile('img')) {
                $image = $request->file('img');
                $imageName = 'picture.' . $image->getClientOriginalExtension();
                $image->move(public_path('images'), $imageName);

                // Store the 'img' column in the database with the image path
                $product = new Product;
                $product->name = $request->name;
                $product->img = 'images/' . $imageName;
                $product->variant = $request->variant;
                $product->price = $request->price;
                $product->save();
            }

            return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
        } else {
            throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
        }
    }

    public function update(Request $request, $id)
    {
        if (auth()->guard('admin')->check()) {
            $request->validate([
                'name' => 'required',
                'img' => 'image|mimes:jpeg,jpg,png|max:5120',
                'variant' => 'required|exists:variants,name',
                'price' => 'required|numeric',
            ]);

            $product = Product::find($id);

            // Handle the uploaded image
            if ($request->hasFile('img')) {
                $image = $request->file('img');
                $imageName = 'picture.' . $image->getClientOriginalExtension();
                $image->move(public_path('images'), $imageName);

                // Update the 'img' column in the database with the image path
                $product->img = 'images/' . $imageName;
                $product->save();
            }
            $product->name = $request->input('name');
            $product->variant = $request->input('variant');
            $product->price = $request->input('price');
            $product->save();

            return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
        } else {
            throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
        }
    }

    public function addStock(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:product,id',
            'stock' => 'required|integer',
            'date_created' => 'required|date',
            'expiration_date' => 'required|date|after_or_equal:date_created',
        ]);

        ProductStock::create([
            'product_id' => $request->product_id,
            'stock' => $request->stock,
            'date_created' => $request->date_created,
            'expiration_date' => $request->expiration_date,
        ]);

        return redirect()->route('admin.product.index')->with('success', 'Product stock added successfully.');
    }
}
