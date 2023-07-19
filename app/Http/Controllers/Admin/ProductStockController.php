<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\Variants;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class ProductStockController extends Controller
{
    //
    public function index(Product $product)
    {
        if (auth()->guard('admin')->check()) {
            $productStock = ProductStock::where('product_id', $product->id)->get();
            $totalStock = $productStock->sum('stock');
            return view('admin.products.inventory.stock', compact('product', 'productStock', 'totalStock'));
        } else {
            throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
        }
    }

    public function store(Request $request, Product $product)
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
}
