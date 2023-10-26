<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ActivityLog;
use App\Models\Product;
use App\Models\Cart;
use App\Models\PaymentMethod;
use App\Models\PaymentReciept;
use App\Models\Order;
use App\Models\Sales;
use App\Models\OnlineShopper;
use App\Models\Retailer;
use App\Models\DeliveryFee;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Mail\RejectedMailNotif;
use App\Mail\approvedOrder;
use App\Mail\OtwNotif;
use App\Mail\DeliveredNotif;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Helpers\AdminHelper;
use App\Events\OrderNotification;

class OrderController extends Controller
{
    //
    public function index()
    {
        if (auth()->guard('admin')->check()) {
            session()->forget('selected_products');
            $orders = Order::with('customer')->get();
            // dd($orders);
            return view('admin.orders.index', compact('orders'));
        } else {
            return redirect()->route('login.administrator');
        }
    }

    public function create()
    {
        if (auth()->guard('admin')->check()) {
            session()->forget('selected_products');

            $customer_details = Retailer::all();
            $products = Product::with('variant')->get();
            return view('admin.orders.create', compact('customer_details', 'products'));
        } else {
            return redirect()->route('login.administrator');
        }
    }

    public function store_customer(Request $request)
    {

        if (auth()->guard('admin')->check()) {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string|max:255|min:2',
                'last_name' => 'required|string|max:255|min:2',
                'mobile_number' => ['required', 'numeric', 'digits:10', 'regex:/^9\d{9}$/'],
                'store_name' => 'required|string|max:255|min:2',
                'remarks' => 'string|nullable',

            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $jsonData = file_get_contents(public_path('js/philippine_address_2019v2.json'));
            $addressData = json_decode($jsonData, true);

            $addresses = $request->validate([
                'region' => ['string', 'required', 'max:255'],
                'province' => ['string', 'required', 'max:255'],
                'barangay' => ['string', 'required', 'max:255'],
                'municipality' => ['string', 'required', 'max:255'],
                'street' => ['string', 'required', 'max:255'],
                'zip_code' => ['integer', 'required', 'digits:4']
            ]);

            if (
                isset($addressData[$addresses['region']]) &&
                isset($addressData[$addresses['region']]['province_list'][$addresses['province']]) &&
                isset($addressData[$addresses['region']]['province_list'][$addresses['province']]['municipality_list'][$addresses['municipality']]) &&
                in_array($addresses['barangay'], $addressData[$addresses['region']]['province_list'][$addresses['province']]['municipality_list'][$addresses['municipality']]['barangay_list'])
            ) {
                $regionName = $addressData[$addresses['region']]['region_name'];
            } else {
                return response()->json(['errors' => 'address'], 422);
            }

            $completeAddress = $request->input('street') . ' ' . ucwords(strtolower($request->input('barangay'))) . ', ' . ucwords(strtolower($request->input('municipality'))) . ', ' . ucwords(strtolower($request->input('province'))) . ', ' . $request->input('zip_code') . ' PHILIPPINES';

            $customer = new Retailer;
            $customer->first_name = $request->first_name;
            $customer->last_name = $request->last_name;
            $customer->mobile_number = $request->mobile_number;
            $customer->store_name = $request->store_name;
            $customer->region = $regionName;
            $customer->province = $addresses['province'];
            $customer->municipality = $addresses['municipality'];
            $customer->barangay = $addresses['barangay'];
            $customer->street = $addresses['street'];
            $customer->zip_code = $addresses['zip_code'];
            $customer->complete_address = $completeAddress;
            $customer->remarks = ($request->remarks) ? $request->remarks : null;
            $customer->save();

            $this->logActivity(auth()->guard('admin')->user()->name . ' has created the following retailer customer: ' . $customer->first_name . ' ' . $customer->last_name, $request);

            return response()->json($customer);
        } else {
            return redirect()->route('login.administrator');
        }
    }

    public function populate_address(Request $request)
    {
        $address = Retailer::where('id', $request->id)->first();

        $jsonData = file_get_contents(public_path('js/philippine_address_2019v2.json'));
        $addressData = json_decode($jsonData, true);

        $allowedRegionCodes = ['01', '02', '03', '4A', '05', 'CAR', 'NCR'];

        $regions = array_filter($addressData, function ($regionCode) use ($allowedRegionCodes) {
            return in_array($regionCode, $allowedRegionCodes);
        }, ARRAY_FILTER_USE_KEY);

        return response()->json(['customer' => $address, 'regions' => $regions, 'addressData' => $addressData]);
    }

    public function edit_customer(Request $request)
    {
        if (auth()->guard('admin')->check()) {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string|max:255|min:2',
                'last_name' => 'required|string|max:255|min:2',
                'mobile_number' => ['required', 'numeric', 'digits:10', 'regex:/^9\d{9}$/'],
                'store_name' => 'required|string|max:255|min:2',
                'remarks' => 'string',

            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $jsonData = file_get_contents(public_path('js/philippine_address_2019v2.json'));
            $addressData = json_decode($jsonData, true);

            $addresses = $request->validate([
                'region' => ['string', 'required', 'max:255'],
                'province' => ['string', 'required', 'max:255'],
                'barangay' => ['string', 'required', 'max:255'],
                'municipality' => ['string', 'required', 'max:255'],
                'street' => ['string', 'required', 'max:255'],
                'zip_code' => ['integer', 'required', 'digits:4']
            ]);

            if (
                isset($addressData[$addresses['region']]) &&
                isset($addressData[$addresses['region']]['province_list'][$addresses['province']]) &&
                isset($addressData[$addresses['region']]['province_list'][$addresses['province']]['municipality_list'][$addresses['municipality']]) &&
                in_array($addresses['barangay'], $addressData[$addresses['region']]['province_list'][$addresses['province']]['municipality_list'][$addresses['municipality']]['barangay_list'])
            ) {
                $regionName = $addressData[$addresses['region']]['region_name'];
            } else {
                return response()->json(['errors' => 'address'], 422);
            }

            $completeAddress = $request->input('street') . ' ' . ucwords(strtolower($request->input('barangay'))) . ', ' . ucwords(strtolower($request->input('municipality'))) . ', ' . ucwords(strtolower($request->input('province'))) . ', ' . $request->input('zip_code') . ' PHILIPPINES';

            $customer = Retailer::where('id', $request->customer_id)->first();
            $customer->first_name = $request->first_name;
            $customer->last_name = $request->last_name;
            $customer->mobile_number = $request->mobile_number;
            $customer->store_name = $request->store_name;
            $customer->region = $regionName;
            $customer->province = $addresses['province'];
            $customer->municipality = $addresses['municipality'];
            $customer->barangay = $addresses['barangay'];
            $customer->street = $addresses['street'];
            $customer->zip_code = $addresses['zip_code'];
            $customer->complete_address = $completeAddress;
            $customer->remarks = ($request->remarks) ? $request->remarks : null;
            $customer->save();

            $this->logActivity('Administrator has made the following changes to a wholesale customer: ' . $customer->first_name . ' ' . $customer->last_name, $request);

            return response()->json($customer);
        } else {
            return redirect()->route('login.administrator');
        }
    }

    public function fetch_customer(Request $request)
    {
        $customer_details = Retailer::all();
        return response()->json($customer_details);
    }

    public function get_customer(Request $request)
    {
        $id = $request->id;
        $customer = Retailer::findOrFail($id);

        return response()->json($customer);
    }

    public function selected_products(Request $request)
    {
        $selectedProducts = $request->input('products', []);
        $productsData = [];

        foreach ($selectedProducts as $product) {
            $productData = Product::where('id', $product['product_id'])->with('variant')->first();
            $price = $productData->price;
            $name = $productData->name;
            $variant = $productData->variant->name;
            $img = $productData->img;
            $quantity = $product['quantity'];
            $discount = $product['discount'];

            // Calculate the price without discount
            $priceWithoutDiscount = $price;

            // Calculate the total price after applying the discount per quantity
            $totalPrice = ($price - $discount) * $quantity;

            $productsData[] = [
                'product_id' => $product['product_id'],
                'name' => $name,
                'variant' => $variant,
                'img' => $img,
                'quantity' => $quantity,
                'discount' => $discount,
                'price' => $priceWithoutDiscount,
                'total' => $totalPrice,
            ];
        }

        session()->put('selected_products', $productsData);

        $total = 0;
        $html = '';

        foreach ($productsData as $product) {
            $productData = Product::findOrFail($product['product_id']);

            $html .= '<div class="col-md-6 mb-3">';
            $html .= '<div class="card shadow">';
            $html .= '<div class="card-header">';
            $html .= '<p>' . $productData->name . '</p>';
            $html .= '</div>';
            $html .= '<div class="card-body">';
            $html .= '<p class="fw-bold">Price: ₱' . $product['price'] . '.00</p>';
            $html .= '<div class="form-floating mb-3">';
            $html .= '<input type="number" class="form-control quantity-input" id="quantity_' . $productData->id . '" value="' . $product['quantity'] . '" min="1">';
            $html .= '<label for="quantity_' . $productData->id . '">Quantity *</label>';
            $html .= '</div>';
            $html .= '<div class="input-group mb-3"><span class="input-group-text">₱</span>';
            $html .= '<div class="form-floating">';
            $html .= '<input type="number" class="form-control discount-input" id="discount_' . $productData->id . '" value="' . $product['discount'] . '" min="0">';
            $html .= '<label for="discount_' . $productData->id . '">Discount (optional)</label>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '<p class="fw-bold">Total: ₱' . $product['total'] . '.00</p>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</div>';

            $total += $product['total'];
        }

        $response = [
            'html' => $html,
            'total' => '₱' . $total . '.00'
        ];

        return response()->json($response);
    }

    public function store_order(Request $request)
    {
        if (auth()->guard('admin')->check()) {

            $validator = $request->validate([
                'customer_details' => 'required|exists:retailers,id',
                'delivery_fee' => 'required|numeric|min:1'
            ]);

            if (session()->has('selected_products')) {

                foreach (session('selected_products') as $item) {
                    $product = Product::find($item['product_id']);

                    if ($product) {
                        if ($product->status == 'AVAILABLE') {
                        } else {
                            return redirect()->back()->with('message', [
                                'type' => 'error',
                                'title' => 'Product Status Alert',
                                'body' => 'The status of some selected products is set to "Not Available". Please review and update the product availability if necessary.',
                                'period' => false,
                            ]);
                        }
                        $remainingStock = $product->stocks - $item['quantity'];

                        if ($remainingStock >= 0) {
                        } else {
                            return redirect()->back()->with('message', [
                                'type' => 'error',
                                'title' => 'Insufficient Stock',
                                'body' => "The quantity you're trying to order exceeds the available stock. Please adjust your order quantity.",
                                'period' => false,
                            ]);
                        }
                    } else {
                        return redirect()->back()->with('message', [
                            'type' => 'error',
                            'title' => 'Product Not Found',
                            'body' => "The requested product was not found in our database. Please verify the product details and try again.",
                            'period' => false,
                        ]);
                    }
                }
                function generateOrderId()
                {
                    $currentDate = now();
                    $monthYear = $currentDate->format('my');
                    $lastOrder = DB::table('orders')->orderByDesc('id')->first();

                    if ($lastOrder) {
                        $lastOrderDate = Carbon::parse($lastOrder->created_at);
                        $lastOrderMonthYear = $lastOrderDate->format('my');

                        if ($lastOrderMonthYear === $monthYear) {
                            $lastOrderId = $lastOrder->order_number;
                            $lastNumber = intval(substr($lastOrderId, 0, -6)); // Extract first digit
                            $nextNumber = $lastNumber + 1;
                            return $nextNumber . 'DR' . $monthYear;
                        }
                    }

                    // If no last order or the month/year has changed, reset the number to 1
                    return '1DR' . $monthYear;
                }

                $orderId = generateOrderId();
                $items = [];
                $grand_total = 0;
                foreach (session('selected_products') as $product) {
                    $item = [
                        "product_id" => $product['product_id'],
                        "name" => $product['name'],
                        'variant' => $product['variant'],
                        'img' => $product['img'],
                        "price" => $product['price'],
                        "discount" => $product['discount'],
                        "quantity" => $product['quantity'],
                        "total" => $product['total'],
                    ];
                    $items[] = $item;
                    $grand_total += $product['total'];
                }
                $retailer = Retailer::find($request->customer_details);

                $order = new Order;
                $order->name = $retailer->first_name . ' ' . $retailer->last_name;
                $order->mobile_number = $retailer->mobile_number;
                $order->store_name = $retailer->store_name;
                $order->address = $retailer->street . ', ' . ucwords(strtolower($retailer->barangay)) . ', ' . ucwords(strtolower($retailer->municipality)) . ', ' . ucwords(strtolower($retailer->province)) . ', ' . $retailer->zip_code . ' Philippines';
                $order->order_number = $orderId;
                $order->grand_total = $grand_total;
                $order->customer_id = $retailer->id;
                $order->customer_type = 'retailer';
                $order->items = $items;
                $order->shipping_option = 'Delivery';
                $order->delivery_fee = $request->input('delivery_fee');
                $order->payment_method = 'Cash On Delivery';
                $order->ip_address =  $request->ip();
                $order->save();
                foreach (session('selected_products') as $item) {
                    $product = Product::find($item['product_id']);
                    $remainingStock = $product->stocks - $item['quantity'];
                    $product->stocks = $remainingStock;
                    $product->save();
                }
                session()->forget('selected_products');

                $this->logActivity(auth()->guard('admin')->user()->name . ' has added a new order: ' . $order->order_number, $request);

                return redirect()->route('admin.orders.index')->with('message', [
                    'type' => 'success',
                    'title' => 'Order Placed',
                    'body' => 'Your order has been successfully placed.',
                ]);
            } else {
                return redirect()->back()->with('message', [
                    'type' => 'error',
                    'title' => ' Empty Cart',
                    'body' => 'Your cart is empty. Please add items before proceeding to checkout.',
                ]);
            }
        }
    }

    public function store(Request $request)
    {
    }

    public function ref(Request $request)
    {
        if (auth()->guard('admin')->check()) {
            $validator = Validator::make($request->all(), [
                'ref' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $order = Order::findOrFail($request->input('order_id'));
            $order->reference_number = $request->input('ref');
            $order->save();

            $validatedData = $validator->validated();
            $data = [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'ref' => $request->input('ref')
            ];

            return response()->json($data);
        } else {
        }
    }

    public function fetch(Request $request)
    {
        if (auth()->guard('admin')->check()) {

            $order = Order::findOrFail($request->input('order_id'));

            $data = [
                // 'order_id' => $order->id,
                // 'order_number' => $order->order_number,
                'ref' => $order->reference_number
            ];

            return response()->json($data);
        }
    }

    public function show($id)
    {
        if (auth()->guard('admin')->check()) {
            $order = Order::findOrFail($id);
            $statusBadge = null;
            if ($order->shipping_option == 'Delivery') {
            } elseif ($order->shipping_option == 'Pick Up') {
            }
            switch ($order->status) {
                case 'Pending':
                    $statusBadge = 'badge-info';
                    break;
                case 'Approved':
                    $statusBadge = 'badge-primary';
                    break;
                case 'On The Way':
                    $statusBadge = 'badge-warning';
                    break;
                case 'Delivered':
                    $statusBadge = 'badge-success';
                    break;
                case 'Rejected':
                    $statusBadge = 'badge-danger';
                    break;
                default:
                    break;
            }

            return view('admin.orders.show', compact('order', 'statusBadge'));
        } else {
            return redirect()->route('login.administrator');
        }
    }

    public function printInvoice($id)
    {
        $order = Order::findOrFail($id);
        return view('admin.orders.print-invoice', compact('order'));
    }

    public function approved(Request $request, $id)
    {
        if (auth()->guard('admin')->check()) {
            $order = Order::findOrFail($id);
            if ($order->status == 'Pending') {
                $order->status = 'Approved';
                $order->save();

                if ($order->customer_type != 'retailer') {
                    $orderData = [
                        'name' => $order->name,
                        'mobile_number' => $order->mobile_number,
                        'address' => $order->address,
                        'email' => $order->email,
                        'order_number' => $order->order_number,
                        'reference_number' => $order->reference_number,
                        'payment_method' => $order->payment_method,
                        'created_at' => $order->updated_at,
                        'items' => $order->items,
                        'grand_total' => $order->grand_total,
                    ];
                    Mail::to($order->email)->send(new approvedOrder($orderData));
                }

                $this->logActivity(auth()->guard('admin')->user()->name . ' updated the status of Order ' . $order->order_number . ' to ' . $order->status, $request);
                return redirect()->route('admin.orders.show', ['id' => $id])->with('message', [
                    'type' => 'info',
                    'title' => 'Order Approved',
                    'body' => 'Order ' . $order->order_number . ' has been approved successfully.',
                ]);
            } else {
                return redirect()->route('admin.orders.index')->with('message', [
                    'type' => 'error',
                    'title' => 'Error',
                    'body' => 'Something went wrong. Please try again.',
                ]);
            }
        } else {
            return redirect()->route('login.administrator');
        }
    }

    public function onTheWay(Request $request, $id)
    {
        if (auth()->guard('admin')->check()) {
            $order = Order::findOrFail($id);
            if ($order->status == 'Approved') {
                $order->status = 'On The Way';
                $order->save();
                if ($order->customer_type != 'retailer') {
                    $orderData = [
                        'name' => $order->name,
                        'mobile_number' => $order->mobile_number,
                        'email' => $order->email,
                        'address' => $order->address,
                        'order_number' => $order->order_number,
                        'reference_number' => $order->reference_number,
                        'payment_method' => $order->payment_method,
                        'created_at' => $order->updated_at,
                        'items' => $order->items,
                        'grand_total' => $order->grand_total,
                        'comments' => $order->comments,
                    ];
                    Mail::to($order->email)->send(new OtwNotif($orderData));
                }
                $this->logActivity(auth()->guard('admin')->user()->name . ' updated the status of Order ' . $order->order_number . ' to ' . $order->status, $request);
                return redirect()->route('admin.orders.show', ['id' => $id])->with('message', [
                    'type' => 'info',
                    'title' => 'Order Shipped',
                    'body' => 'Order ' . $order->order_number . ' is on the way for deliver.',
                ]);
            } else {
                return redirect()->route('admin.orders.index')->with('message', [
                    'type' => 'error',
                    'title' => 'Error',
                    'body' => 'Something went wrong. Please try again.',
                ]);
            }
        } else {
            return redirect()->route('login.administrator');
        }
    }

    public function pickUp(Request $request, $id)
    {
        if (auth()->guard('admin')->check()) {
            $order = Order::findOrFail($id);
            if ($order->status == 'Approved') {
                $order->status = 'Ready To Pick Up';
                $order->save();
                $this->logActivity(auth()->guard('admin')->user()->name . ' updated the status of Order ' . $order->order_number . ' to ' . $order->status, $request);
                return redirect()->route('admin.orders.show', ['id' => $id]);
            } else {
                return redirect()->route('admin.orders.index')->with('error', 'Something went wrong.');
            }
        } else {
            return redirect()->route('login.administrator');
        }
    }

    public function delivered(Request $request, $id)
    {
        if (auth()->guard('admin')->check()) {
            $order = Order::findOrFail($id);
            if ($order->status != 'On The Way') {
                $order->status = 'Delivered';

                $order->save();
                if ($order->customer_type != 'retailer') {
                    $orderData = [
                        'name' => $order->name,
                        'mobile_number' => $order->mobile_number,
                        'email' => $order->email,
                        'address' => $order->address,
                        'order_number' => $order->order_number,
                        'reference_number' => $order->reference_number,
                        'payment_method' => $order->payment_method,
                        'created_at' => $order->updated_at,
                        'items' => $order->items,
                        'grand_total' => $order->grand_total,
                        'comments' => $order->comments,
                    ];
                    Mail::to($order->email)->send(new DeliveredNotif($orderData));
                }

                foreach ($order->items as $sales) {
                    Sales::create([
                        'category' => 'Products',
                        'name' => $sales['name'],
                        'price' => $sales['price'],
                        'quantity' => $sales['quantity'],
                        'amount' => $sales['total'],
                        'created_at' => Carbon::now(),
                    ]);
                }

                $this->logActivity(auth()->guard('admin')->user()->name . ' updated the status of Order ' . $order->order_number . ' to ' . $order->status, $request);
                return redirect()->route('admin.orders.show', ['id' => $id])->with('message', [
                    'type' => 'info',
                    'title' => 'Order Delivered',
                    'body' => 'Order ' . $order->order_number . ' has delivered successfully.',
                ]);
            } else {
                return redirect()->route('admin.orders.index')->with('message', [
                    'type' => 'error',
                    'title' => 'Error',
                    'body' => 'Something went wrong. Please try again.',
                ]);
            }
        } else {
            return redirect()->route('login.administrator');
        }
    }

    public function reject(Request $request, $id)
    {
        if (auth()->guard('admin')->check()) {
            $order = Order::findOrFail($id);
            $request->validate([
                'remarks' => ['required', 'max:255'],
            ]);
            if ($order->status == 'Pending') {
                $order->status = 'Rejected';
                $order->comments = $request->input('remarks');
                $order->save();

                if ($order->customer_type != 'retailer') {
                    $orderData = [
                        'name' => $order->name,
                        'mobile_number' => $order->mobile_number,
                        'email' => $order->email,
                        'address' => $order->address,
                        'order_number' => $order->order_number,
                        'reference_number' => $order->reference_number,
                        'payment_method' => $order->payment_method,
                        'created_at' => $order->created_at,
                        'items' => $order->items,
                        'grand_total' => $order->grand_total,
                        'comments' => $order->comments,
                    ];
                    Mail::to($order->email)->send(new RejectedMailNotif($orderData));
                }

                $this->logActivity(auth()->guard('admin')->user()->name . ' updated the status of Order ' . $order->order_number . ' to ' . $order->status, $request);
                return redirect()->route('admin.orders.show', ['id' => $id])->with('message', [
                    'type' => 'info',
                    'title' => 'Order Rejected',
                    'body' => 'Order ' . $order->order_number . ' has been rejected.',
                ]);
            } else {
                return redirect()->route('admin.orders.index')->with('message', [
                    'type' => 'error',
                    'title' => 'Error',
                    'body' => 'Something went wrong. Please try again.',
                ]);
            }
        } else {
            return redirect()->route('login.administrator');
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
        if ($request->is('admin/orders/{id}/approved')) {
            return 'Orders';
        } elseif ($request->is('admin/orders/{id}/otw')) {
            return 'Orders';
        } elseif ($request->is('admin/orders/{id}/pickup')) {
            return 'Orders';
        } elseif ($request->is('admin/orders/{id}/delivered')) {
            return 'Orders';
        } elseif ($request->is('admin/orders/{id}/reject')) {
            return 'Orders';
        } else {
            return 'Others';
        }
    }
}
