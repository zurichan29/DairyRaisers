<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductStock;
use Illuminate\Http\Request;

class ProductDashboardController extends Controller
{
    public function index()
    {
        // Add any necessary logic for the product dashboard
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }

    public function manageProduct()
    {
        // Add any necessary logic for managing products
        $products = Product::all();
        return view('admin.products.manage',  compact('products'));
    }

    public function manageStock()
    {
        $products = Product::all();
        return view('admin.products.stock', compact('products'));
    }

    public function storeStock(Request $request)
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

        return redirect()->route('admin.product.manage.stock')->with('success', 'Product stock added successfully.');
    }

    public function storeProductStock(Request $request)
    {
        // Validate the request data
        $request->validate([
            'product_id' => 'required|exists:product,id',
            'stock' => 'required|numeric',
        ]);

        // Retrieve the product
        $product = Product::findOrFail($request->product_id);

        // Check if a stock entry with the same date_created exists
        $existingStock = $product->stocks()
            ->where('date_created', now()->toDateString())
            ->first();

        if ($existingStock) {
            // Update the existing stock entry by adding the new stock quantity
            $existingStock->stock += $request->stock;
            $existingStock->save();
        } else {
            // Calculate the expiration date
            $expirationDate = now()->addDays(7);

            // Create a new stock entry
            $product->stocks()->create([
                'stock' => $request->stock,
                'date_created' => now(),
                'expiration_date' => $expirationDate,
            ]);
        }

        // Return a JSON response with the updated stock data
        $stockData = $product->stocks()->orderBy('date_created')->pluck('stock');

        return response()->json(['labels' => $stockData->keys(), 'datasets' => [['label' => 'Stock Quantity', 'data' => $stockData->values()]]]);
    }




    public function getStockData($productId)
    {
        $productStocks = ProductStock::where('product_id', $productId)->orderBy('created_at')->get();

        $labels = $productStocks->pluck('created_at')->map(function ($date) {
            return $date->format('Y-m-d');
        });

        $datasets = [
            [
                'label' => 'Stock Quantity',
                'data' => $productStocks->pluck('stock'),
                'backgroundColor' => 'rgba(0, 123, 255, 0.5)',
                'borderColor' => 'rgba(0, 123, 255, 1)',
                'borderWidth' => 1,
            ],
        ];

        return response()->json([
            'labels' => $labels,
            'datasets' => $datasets,
        ]);
    }
}
