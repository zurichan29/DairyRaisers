<?php

namespace App\Http\Controllers\Admin;

use App\Models\Buffalo;
use App\Models\BuffaloSales;
use App\Models\Sales;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class DairyController extends Controller
{
    public function index()
    {
        $babyMaleCount = Buffalo::where('gender', 'male')->where('age', 'baby')->first()->quantity;
        $babyFemaleCount = Buffalo::where('gender', 'female')->where('age', 'baby')->first()->quantity;
        $adultMaleCount = Buffalo::where('gender', 'male')->where('age', 'adult')->first()->quantity;
        $adultFemaleCount = Buffalo::where('gender', 'female')->where('age', 'adult')->first()->quantity;
        $buffaloCount = Buffalo::all()->sum('quantity');
        $buffalo_sales = BuffaloSales::all();

        return view('admin.buffalos.index', compact('buffalo_sales', 'babyMaleCount', 'babyFemaleCount', 'adultMaleCount', 'adultFemaleCount', 'buffaloCount'));
    }

    public function buffalo_sales_fetch()
    {
        $buffalo_sales =  BuffaloSales::all();
        return response()->json($buffalo_sales);
    }

    public function buffalo_fetch()
    {
        $buffalo =  Buffalo::all();
        return response()->json($buffalo);
    }

    public function buffalo_update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'male_baby' => 'required|numeric|min:0',
            'female_baby' => 'required|numeric|min:0',
            'male_adult' => 'required|numeric|min:0',
            'female_adult' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();

        $baby_male = Buffalo::where('gender', 'male')->where('age', 'baby')->first();
        $baby_male->quantity = $data['male_baby'];
        $baby_male->save();
        $baby_female = Buffalo::where('gender', 'female')->where('age', 'baby')->first();
        $baby_female->quantity = $data['female_baby'];
        $baby_female->save();
        $adult_male = Buffalo::where('gender', 'male')->where('age', 'adult')->first();
        $adult_male->quantity = $data['male_adult'];
        $adult_male->save();
        $adult_female = Buffalo::where('gender', 'female')->where('age', 'adult')->first();
        $adult_female->quantity = $data['female_adult'];
        $adult_female->save();

        $this->logActivity(auth()->guard('admin')->user()->name . ' performed an update on the buffalo.', $request);

        return response()->json([
            'info' => 'Buffalo updated successfully.',
            'counts' => $this->buffalo_count(),
        ]);
    }

    public function buffalo_sell(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'buyer_name' => 'required|string|max:255',
            'buyer_address' => 'required|string|max:255',
            'mobile_number' => ['required', 'numeric', 'digits:10', 'regex:/^9\d{9}$/'],
            'categories' => 'required|array|min:1',
            'categories.*.gender' => 'required|in:male,female',
            'categories.*.age' => 'required|in:baby,adult',
            'categories.*.quantity' => 'nullable|integer|min:0',
            'categories.*.price' => 'nullable|numeric|min:0',
        ]);

        // Add custom validation rule for each category
        $validator->after(function ($validator) use ($request) {
            $categories = $request->input('categories');

            foreach ($categories as $index => $category) {
                $hasQuantity = isset($category['quantity']);
                $hasPrice = isset($category['price']);

                if (($hasQuantity && !$hasPrice) || (!$hasQuantity && $hasPrice)) {
                    $validator->errors()->add("categories.{$index}.quantity", "The quantity and price fields must both have values or both be empty.");
                    $validator->errors()->add("categories.{$index}.price", "The quantity and price fields must both have values or both be empty.");
                } else {
                    for ($x = 0; $x <= 4; $x++) {
                        $validator->errors()->forget("categories.$x.quantity");
                        $validator->errors()->forget("categories.$x.price");
                    }
                    break;
                }
            }
        });

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $categories = $request->input('categories');
        $totalQuantitySold = 0;
        $grandTotal = 0;
        $details = [];

        foreach ($categories as $index => $category) {
            $hasQuantity = isset($category['quantity']);
            $hasPrice = isset($category['price']);

            if (($hasQuantity && $hasPrice)) {
                $total = $category['price'] * $category['quantity'];
                $details[] = [
                    'gender' => $category['gender'],
                    'age' => $category['age'],
                    'quantity' => $category['quantity'],
                    'price' => $category['price'],
                    'total' => $total,
                ];
                $grandTotal += $total;
                $totalQuantitySold += $category['quantity'];
            }
        }

        foreach ($details as $index => $category) {
            $buffaloCount = Buffalo::where('gender', $category['gender'])->where('age', $category['age'])->first();

            if ($category['quantity'] > $buffaloCount->quantity) {
                return response()->json(['stock' => $category['gender'] . ' ' . $category['age'] . ' category is low on stock.'], 422);
            }
        }

        $data = $validator->validated();

        foreach ($details as $index => $category) {
            $buffaloToRemove = Buffalo::where('gender', $category['gender'])->where('age', $category['age'])->first();
            $buffaloToRemove->quantity = $buffaloToRemove->quantity - $category['quantity'];
            $buffaloToRemove->save();
        }

        $buffaloSale = new BuffaloSales([
            'buyer_name' => $data['buyer_name'],
            'buyer_address' => $data['buyer_address'],
            'mobile_number' => $data['mobile_number'],
            'details' => json_encode($details),
            'total_quantity' => $totalQuantitySold,
            'grand_total' => $grandTotal,
        ]);

        $buffaloSale->save();

        $this->logActivity(auth()->guard('admin')->user()->name . ' performed a transaction to ' . $data['buyer_name'] . ' : ' . $totalQuantitySold . ' Buffalo(s) sold.', $request);

        Sales::create([
            'category' => 'Buffalo',
            'name' => 'Buffalo',
            'price' => $grandTotal,
            'quantity' => $totalQuantitySold,
            'amount' => $grandTotal,
            'created_at' => Carbon::now(),
        ]);

        return response()->json([
            'success' => "Sold {$totalQuantitySold} Buffalo(s) to {$data['buyer_name']}. Transaction completed successfully.",
            'counts' => $this->buffalo_count(),
        ]);
    }

    private function buffalo_count()
    {
        $totalBuffalos = Buffalo::all()->sum('quantity');
        $babyFemaleCount = Buffalo::where('gender', 'female')->where('age', 'baby')->first()->quantity;
        $babyMaleCount = Buffalo::where('gender', 'male')->where('age', 'baby')->first()->quantity;
        $adultFemaleCount = Buffalo::where('gender', 'female')->where('age', 'adult')->first()->quantity;
        $adultMaleCount = Buffalo::where('gender', 'male')->where('age', 'adult')->first()->quantity;

        return [
            'total' => $totalBuffalos,
            'baby_female' => $babyFemaleCount,
            'baby_male' => $babyMaleCount,
            'adult_female' => $adultFemaleCount,
            'adult_male' => $adultMaleCount,
        ];
    }

    public function buffalo_show(Request $request, $id)
    {
        $buffalo_sales = BuffaloSales::where('id', $id)->first();

        return view('admin.buffalos.show', compact('buffalo_sales'));
    }

    public function printInvoice(Request $request, $id) {
        $buffalo_sales = BuffaloSales::where('id', $id)->first();
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
        if ($request->is('admin/dairy')) {
            return 'Buffalos';
        } elseif ($request->is('admin/dairy/buffalo-store')) {
            return 'Buffalos';
        } elseif ($request->is('admin/dairy/buffalo-remove')) {
            return 'Buffalos';
        } elseif ($request->is('admin/dairy/buffalo-sell')) {
            return 'Buffalos';
        } else {
            return 'Others';
        }
    }
}
