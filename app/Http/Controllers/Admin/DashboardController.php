<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Admin;
use App\Models\Order;
use App\Models\Sales;
use App\Models\Buffalo;
use App\Models\Product;
use App\Models\Variants;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;

use Illuminate\Support\Carbon;
use App\Events\OrderNotification;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class DashboardController extends Controller
{
    //
    public function index()
    {
        if (auth()->guard('admin')->check()) {
            $staffs = Admin::all();
            $buffalos = Buffalo::all();
            $products = Product::all();
            $orders = Order::all();
            $logs = ActivityLog::latest()->limit(5)->get();
            $payment_methods = PaymentMethod::all();

            $buffaloData = [];
            foreach ($buffalos as $buffalo) {
                $buffaloData[] = $buffalo->quantity;
            }

            $variants = Variants::all();
            $productStocksLabels = [];
            $productStocksDatasets = [];
            foreach ($variants as $variant) {
                $stocks = Product::where('variants_id', $variant->id)->get()->sum('stocks');
                $productStocksLabels[] = $variant->name;
                $productStocksDatasets[] = [
                    'label' => $variant->name,
                    'data' => $stocks,
                    'borderColor' => '#' . substr(md5(rand()), 0, 6),
                ];
            }

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

            $monthlySalesLabel = $months->toArray();
            $earningData = [];

            for ($i = 0; $i < 12; $i++) {
                $monthData = $salesData->filter(function ($value) use ($i) {
                    return $value->month === ($i + 1);
                });

                $productsEarnings = $monthData->where('category', 'Products')->sum('total_earnings');
                $buffaloEarnings = $monthData->where('category', 'Buffalo')->sum('total_earnings');

                $earningData[] = [$productsEarnings, $buffaloEarnings];
            }



            // dd($buffaloData);

            return view('admin.index', compact('products', 'staffs', 'buffalos', 'orders', 'buffaloData', 'productStocksDatasets', 'productStocksLabels', 'years', 'currentYear', 'monthlySalesLabel', 'earningData', 'logs', 'payment_methods'));
        } else {
            return redirect()->route('login.administrator');
        }
    }

   

    public function send_notifications()
    {

        $order = 'IM CHRISTIAN JAY';

        event(new OrderNotification($order));

        return redirect()->route('admin.dashboard');
    }

    public function downloadChart(Request $request)
    {
        // Assuming you have received the chart image data from the client side
        $base64ImageData = $request->input('chartImageData');
    
        // Set the appropriate headers for image download
        $headers = [
            'Content-Type' => 'image/png',
            'Content-Disposition' => 'attachment; filename="chart.png"',
            'Content-Length' => strlen(base64_decode($base64ImageData)),        
        ];
    
        // Return the image as a downloadable response
        return Response::make(base64_decode($base64ImageData), 200, $headers);
    }
}
