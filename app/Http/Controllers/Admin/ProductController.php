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

            return view('admin.products.index', compact('products'));
        } else {
            throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
        }
    }

    public function create()
    {
        if (auth()->guard('admin')->check()) {
            return view('admin.products.inventory.create');
        } else {
            throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
        }
    }

    public function stock(Product $product)
    {
        if (auth()->guard('admin')->check()) {
            $productStock = ProductStock::where('product_id', $product->id)->get();
            $totalStock = $productStock->sum('stock');
            return view('admin.products.inventory.stock', compact('product', 'productStock', 'totalStock'));
        } else {
            throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
        }
    }

    public function variants()
    {
        if (auth()->guard('admin')->check()) {
            $variants = Variants::all();
            return view('admin.products.variants.index', compact('variants'));
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
            return view('admin.products.inventory.edit', compact('product'));
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
                'variant' => 'required',
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

            return redirect()->route('admin.product.manage')->with('success', 'Product created successfully.');
        } else {
            throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
        }
    }

    public function stock_store(Request $request, Product $product)
    {
        if (auth()->guard('admin')->check()) {

            if (!$product) {
                throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
            }

            $request->validate([
                'stock' => 'required|integer',
            ]);

            $currentDate = Carbon::now()->toDateString();
            $expirationDate = Carbon::now()->addDays(7)->toDateString();
            $currentStock = ProductStock::where('product_id', $product->id)->where('date_created', $currentDate)->first();

            if ($currentStock) {
                $currentStock->stock = $currentStock->stock + $request->stock;
                $currentStock->save();
            } else {
                ProductStock::create([
                    'product_id' => $product->id,
                    'stock' => $request->stock,
                    'date_created' => $currentDate,
                    'expiration_date' => $expirationDate,
                ]);
            }

            return redirect()->route('admin.products.index')->with('success', 'Stock has been added on ' . $product->name . '.');
        } else {
            throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
        }
    }

    public function variants_store(Request $request)
    {
        if (auth()->guard('admin')->check()) {
            $new_variant = $request->validate([
                'name' => 'required|unique:variants,name'
            ]);

            Variants::create($new_variant);

            return redirect()->route('admin.products.variants')->with('success', 'New Variants added.');
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

    public function update(Request $request, $id)
    {
        if (auth()->guard('admin')->check()) {
            $request->validate([
                'name' => 'required',
                'img' => 'required|image|mimes:jpeg,jpg,png|max:5120',
                'variant' => 'required',
                'price' => 'required|numeric',
            ]);

            // Handle the uploaded image
            if ($request->hasFile('img')) {
                $image = $request->file('img');
                $imageName = 'picture.' . $image->getClientOriginalExtension();
                $image->move(public_path('images'), $imageName);

                // Update the 'img' column in the database with the image path
                $product = Product::find($id);
                $product->img = 'images/' . $imageName;
                $product->save();
            }
            return redirect()->route('admin.products.show', $id)->with('success', 'Product updated successfully.');
        } else {
            throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
        }
    }
}
