<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sales;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Carbon;

class SalesReportController extends Controller
{
    //
    public function index()
    {
        $currentYear = Carbon::now()->year;
        $years = range($currentYear, $currentYear - 9); // Generate a list of 10 years starting from the current year

        // Get the months collection
        $months = collect(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']);

        // Fetch sales data from the database and calculate total earnings for each month and category
        $salesData = Sales::select(
            DB::raw('MONTH(created_at) as month'),
            'category',
            DB::raw('SUM(amount) as total_earnings')
        )
            ->groupBy('month', 'category')
            ->orderBy('month')
            ->get();

        // Prepare the labels and earnings data for the chart
        $labels = $months->toArray();
        $earningData = [];

        for ($i = 0; $i < 12; $i++) {
            $monthData = $salesData->filter(function ($value) use ($i) {
                return $value->month === ($i + 1);
            });

            $productsEarnings = $monthData->where('category', 'Products')->sum('total_earnings');
            $buffaloEarnings = $monthData->where('category', 'Buffalo')->sum('total_earnings');
            $milkEarnings = $monthData->where('category', 'Milk')->sum('total_earnings');

            $earningData[] = [$productsEarnings, $buffaloEarnings, $milkEarnings];
        }

        return view('admin.sales_report.index', compact('years', 'currentYear', 'labels', 'earningData'));
    }

    public function updateYear(Request $request)
    {
        $selectedYear = $request->input('year');

        // Calculate the starting month number for the selected year
        $currentYear = (int) now()->format('Y');
        $startingMonthNumber = $selectedYear == $currentYear ? ((int) now()->format('m') - 3 + 12) % 12 : 1;

        // Get the months collection
        $months = collect(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']);

        // Fetch sales data from the database for the selected year and calculate total earnings for each month and category
        $salesData = DB::table('sales')
            ->select(
                DB::raw('MONTH(created_at) as month'),
                'category',
                DB::raw('SUM(amount) as total_earnings')
            )
            ->whereYear('created_at', $selectedYear)
            ->groupBy('month', 'category')
            ->orderBy('month')
            ->get();

        // Prepare the labels and earnings data for the chart
        $labels = $months->toArray();
        $earningData = [];

        for ($i = 0; $i < 12; $i++) {
            $monthData = $salesData->filter(function ($value) use ($i) {
                return $value->month === ($i + 1);
            });

            $productsEarnings = $monthData->where('category', 'Products')->sum('total_earnings');
            $buffaloEarnings = $monthData->where('category', 'Buffalo')->sum('total_earnings');
            $milkEarnings = $monthData->where('category', 'Milk')->sum('total_earnings');

            $earningData[] = [$productsEarnings, $buffaloEarnings, $milkEarnings];
        }

        return response()->json([
            'labels' => $labels,
            'earningData' => $earningData,
        ]);
    }

    public function dailySales(Request $request)
    {
        $startDate = Carbon::parse($request->start_date)->startOfDay();
        $endDate = Carbon::parse($request->end_date)->endOfDay();
        $category = $request->input('category', '');

        // Fetch sales data for the selected date range and include the product name, price, and quantity
        $salesData = Sales::whereBetween('created_at', [$startDate, $endDate])
            ->when($category, function ($query, $category) {
                return $query->where('category', $category);
            })
            ->select('name', 'category', 'price', 'quantity', 'created_at', DB::raw('SUM(amount) as total_sales'))
            ->groupBy('name', 'category', 'price', 'quantity', 'created_at')
            ->get();

        return response()->json($salesData);
    }
}
