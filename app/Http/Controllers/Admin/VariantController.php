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
use Illuminate\Support\Facades\Validator;

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
            $new_variant = Validator::make($request->all(), [
                'name' => 'required|unique:variants,name'
            ]);

            if ($new_variant->fails()) {
                return response()->json(['errors' => $new_variant->errors()], 422);
            }

            $variants = new Variants;
            $variants->name = $request->name;
            $variants->save();

            $validatedData = $new_variant->validated();

            return response()->json([
                'variant_id' => $variants->id,
                'name' => $validatedData['name']
            ]);
        } else {
            throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
        }
    }

    public function update(Request $request)
    {
        if (auth()->guard('admin')->check()) {
            $variant = Validator::make($request->all(), [
                'name' => 'required|unique:variants,name'
            ]);

            if ($variant->fails()) {
                return response()->json(['errors' => $variant->errors()], 422);
            }

            $variants = Variants::find($request->input('variant_id'));
            $variants->name = $request->input('name');
            $variants->save();

            $validatedData = $variant->validated();

            return response()->json([
                'variant_id' => $variants->id,
                'name' => $validatedData['name']
            ]);
        } else {
            throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
        }
    }

    public function getVariantsData(Request $request)
    {
        if (auth()->guard('admin')->check()) {
            $variants = Variants::all();
            return response()->json($variants);
        } else {
            throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
        }
    }
}
