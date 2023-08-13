<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Variants;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\ActivityLog;

class ProductController extends Controller
{

    public function index()
    {
        if (auth()->guard('admin')->check()) {
            $products = Product::with('variant')->get();
            $variants = Variants::all();
            return view('admin.products.index', compact('products', 'variants'));
        } else {
            return redirect()->route('login.administrator');
        }
    }

    public function print()
    {
        $products = Product::with('variant')->get();
        $variants = Variants::all();
        return view('admin.products.print', compact('products', 'variants'));
    }

    public function show($id)
    {
        if (auth()->guard('admin')->check()) {
            $product = Product::findOrFail($id);
            // return response()->json($product);
            return view('admin.products.inventory.show', compact('product'));
        } else {
            return redirect()->route('login.administrator');
        }
    }

    public function getProductsData()
    {
        $products = Product::with('variant')->get();
        // Modify the image URL to include the domain name or localhost
        foreach ($products as $product) {
            $product->img = asset($product->img);
        }
        return response()->json($products);
    }

    public function updateStatus(Request $request)
    {
        if (auth()->guard('admin')->check()) {
            $productId = $request->input('productId');
            $currentStatus = $request->input('currentStatus');

            $product = Product::find($productId);

            if (!$product) {
                return response()->json(['error' => 'Product not found'], 404);
            }

            // Determine the new status based on the current status
            $newStatus = ($product->status == 'AVAILABLE') ? 'NOT AVAILABLE' : 'AVAILABLE';

            $product->status = $newStatus;
            $product->save();

            $this->logActivity(auth()->guard('admin')->user()->name . ' has updated the status of ' . $product->name . ' to ' . $product->status, $request);

            return response()->json($product);
        }
    }

    public function addStocks(Request $request)
    {
        if (auth()->guard('admin')->check()) {
            $validator = Validator::make($request->all(), [
                'stock_quantity' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $product = Product::find($request->input('product_id'));

            if (!$product) {
                return response()->json(['error' => 'Product not found'], 404);
            }
            $oldStock = $product->stocks;
            $product->stocks = $product->stocks + $request->input('stock_quantity');
            $product->save();
            $newStock = ($product->stocks >= 0) ? $product->stocks . ' stocks' : $product->stocks . 'stock';

            $this->logActivity('Administrator has added ' . $newStock . ' to  ' . $product->name, $request);

            return response()->json($product);
        }
    }

    public function store(Request $request)
    {
        if (auth()->guard('admin')->check()) {

            $validator = Validator::make($request->all(), [
                'name' => 'required|min:5',
                'img' => 'required|image|mimes:jpeg,jpg,png|max:5120',
                'variant' => 'required|exists:variants,name',
                'price' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $variant = Variants::where('name', $request->variant)->first();

            // Handle the uploaded image
            $image = $request->file('img');
            $imageName = 'picture_' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);

            // Store the 'img' column in the database with the image path
            $newProduct = new Product;
            $newProduct->name = $request->name;
            $newProduct->img = 'images/' . $imageName;
            $newProduct->variants_id = $variant->id;
            $newProduct->price = $request->price;
            $newProduct->save();

            $product = Product::where('id', $newProduct->id)->with('variant')->first();

            $data = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'variant' => $product->variant->name,
            ];
            $this->logActivity(auth()->guard('admin')->user()->name . ' added a new product: ' . $product->name, $request);

            return response()->json($data);
        }
    }

    public function update(Request $request)
    {
        if (auth()->guard('admin')->check()) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|min:3',
                'img' => 'image|mimes:jpeg,jpg,png|max:5120',
                'variant' => 'required|exists:variants,name',
                'price' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            // Fetch the product data
            $product = Product::find($request->input('product_id'));

            // Fetch the variant data
            $variant = Variants::where('name', $request->variant)->first();

            if ($request->hasFile('img')) {
                $image = $request->file('img');
                $imageName = 'picture_' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images'), $imageName);
                $product->img = 'images/' . $imageName;
            }

            // Update other product data
            $product->name = $request->input('name');
            $product->variants_id = $variant->id;
            $product->price = $request->input('price');
            $product->save();

            // Fetch the updated variant data
            $updatedVariant = $product->variant;

            $data = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'variant' => $updatedVariant->name,
                'stock' => $product->stock,
                'img' => $request->file('img'),
            ];

            $this->logActivity(auth()->guard('admin')->user()->name . ' has updated a product: ' . $product->name, $request);

            return response()->json($data);
        }
    }



    // Method to log the activity
    private function logActivity($activityDescription, $request)
    {
        if (auth()->guard('admin')->check()) {
            $activityLog = new ActivityLog([
                'admin_id' => auth()->guard('admin')->user()->id,
                'activity_type' => $this->getActivityType($request),
                'description' => $activityDescription,
                'ip_address' => $request->ip(),
            ]);

            $activityLog->save();
        }
    }

    private function getActivityType($request)
    {
        if ($request->is('admin/products/store')) {
            return 'Products';
        } elseif ($request->is('admin/products/update-status')) {
            return 'Products';
        } elseif ($request->is('admin/products/add-stocks')) {
            return 'Products';
        } elseif ($request->is('admin/products/update')) {
            return 'Products';
        } elseif ($request->is('admin/varaints/store')) {
            return 'Variants';
        } elseif ($request->is('admin/variants/update')) {
            return 'Variants';
        } else {
            return 'Others';
        }
    }
}
