<?php

namespace App\Http\Controllers\Admin;

use App\Models\Buffalo;
use App\Models\MilkStock;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\Exceptions\HttpResponseException;

class BuffaloController extends Controller
{

    public function status(Request $request) {
        if (auth()->guard('admin')->check()) {
            $buffalo = Buffalo::all();

            return view('admin.buffalos.update_buffalo', compact('buffalo'));
        } else {
            throw new HttpResponseException(response()->view('404_page', [], Response::HTTP_NOT_FOUND));
        }
    }
}
