<?php

namespace App\Http\Controllers\Admin;

use App\Models\Sales;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class SalesReportController extends Controller
{
    //
    public function index()
    {
        $currentYear = Carbon::now()->year;
        $years = range($currentYear, $currentYear - 9);

        $months = collect(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']);

        $salesData = Sales::select(
            DB::raw('MONTH(created_at) as month'),
            'category',
            DB::raw('SUM(amount) as total_earnings')
        )
            ->groupBy('month', 'category')
            ->orderBy('month')
            ->get();

        $labels = $months->toArray();
        $earningData = [];

        for ($i = 0; $i < 12; $i++) {
            $monthData = $salesData->filter(function ($value) use ($i) {
                return $value->month === ($i + 1);
            });

            $productsEarnings = $monthData->where('category', 'Products')->sum('total_earnings');
            $buffaloEarnings = $monthData->where('category', 'Buffalo')->sum('total_earnings');

            $earningData[] = [$productsEarnings, $buffaloEarnings];
        }

        return view('admin.sales_report.index', compact('years', 'currentYear', 'labels', 'earningData'));
    }

    public function print()
    {
        $currentYear = Carbon::now()->year;
        $years = range($currentYear, $currentYear - 9);

        $months = collect(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']);

        $salesData = Sales::select(
            DB::raw('MONTH(created_at) as month'),
            'category',
            DB::raw('SUM(amount) as total_earnings')
        )
            ->groupBy('month', 'category')
            ->orderBy('month')
            ->get();

        $labels = $months->toArray();
        $earningData = [];

        for ($i = 0; $i < 12; $i++) {
            $monthData = $salesData->filter(function ($value) use ($i) {
                return $value->month === ($i + 1);
            });

            $productsEarnings = $monthData->where('category', 'Products')->sum('total_earnings');
            $buffaloEarnings = $monthData->where('category', 'Buffalo')->sum('total_earnings');

            $earningData[] = [$productsEarnings, $buffaloEarnings];
        }

        return view('admin.sales_report.print', compact('years', 'currentYear', 'labels', 'earningData'));
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

            $earningData[] = [$productsEarnings, $buffaloEarnings];
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
    

    public function downloadChart(Request $request)
    {
        // Assuming you have received the chart image data from the client side
        $base64ImageData = $request->input('chartImageData');

        // Decode the base64 image data
        $imageData = base64_decode($base64ImageData);

        // Set the appropriate headers for image download
        $headers = [
            'Content-Type' => 'application/octet-stream',
            'Content-Disposition' => 'attachment; filename="monthly-sales-chart.png"',
            'Content-Length' => strlen($imageData),
        ];

        // Return the image as a downloadable response
        return Response::make($imageData, 200, $headers);
    }


}