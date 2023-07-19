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

class VariantController extends Controller
{
    //
    public function index()
    {
        if (auth()->guard('admin')->check()) {
            $variants = Variants::all();
            return view('admin.products.variants.index', compact('variants'));
        } else {
            throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
        }
    }

    public function store(Request $request)
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

}
