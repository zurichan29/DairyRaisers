<?php

use App\Models\Buffalo;
use App\Events\OrderNotification;

// ADMIN
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarGraphController;
use App\Http\Controllers\Admin\DairyController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Client\AuthController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\PageController;
use App\Http\Controllers\Client\ShopController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\CsvExportController;

// CLIENT
use App\Http\Controllers\Admin\VariantController;
use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MilkStockController;
use App\Http\Controllers\Client\CheckoutController;
use App\Http\Controllers\Client\RegisterController;
use App\Http\Controllers\Admin\SalesReportController;
use App\Http\Controllers\Admin\ActivityLogsController;
use App\Http\Controllers\Admin\ProductStockController;
use App\Http\Controllers\Admin\PaymentMethodController;
use App\Http\Controllers\Client\OrderController as ClientOrder;
use App\Http\Controllers\Admin\OrderController as OrderManagement;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
*/

/* HOME */

Route::get('/', [PageController::class, 'index'])->name('index');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/terms', [PageController::class, 'terms'])->name('terms');
Route::get('/faqs', [PageController::class, 'faqs'])->name('faqs');
Route::get('/payment', [PageController::class, 'payment']);
Route::get('/detail', [PageController::class, 'detail'])->name('orders');

/** CART MANAGEMENT */
Route::get('/cart', [CartController::class, 'cart'])->name('cart');
Route::post('/cart/update', [CartController::class, 'updateQuantity'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'removeCart'])->name('cart.remove');
Route::get('/cart/count', [CartController::class, 'getCartCount']);

/** SHOP */
Route::get('/shop/products', [ShopController::class, 'show'])->name('shop');
Route::get('/location', [ShopController::class, 'location'])->name('location');
Route::get('/update-location', [ShopController::class, 'update_location_form'])->name('location.update-show');
Route::post('/confirm-location/{backRoute}', [ShopController::class, 'confirm_location'])->name('location.confirm');
Route::post('/update-location', [ShopController::class, 'update_location'])->name('location.update');
Route::post('/update-cart', [ShopController::class, 'updateCart'])->name('product.update-cart');
Route::post('/fetch-cart', [ShopController::class, 'fetchCart'])->name('product.fetch-cart');


Route::group(['middleware' => 'check.client:' . false], function () {
    /** AUTHENTICATION */
    Route::get('/login', [AuthController::class, 'show'])->name('login');
    Route::post('/login/authenticate', [AuthController::class, 'authenticate'])->name('authenticate');
    Route::get('/reset-password', [AuthController::class, 'reset_password'])->name('reset_password');
    Route::post('/check-reset-password-form', [AuthController::class, 'verify_rp'])->name('reset_password.validate');
    Route::get('/reset-password/{token}/{email}', [AuthController::class, 'new_password'])->name('reset_password.new-password');
    Route::post('/reset-password/new-password/{token}/{email}/validate', [AuthController::class, 'verify_np'])->name('reset_password.verify-new-password');

    /**REGISTER */
    Route::get('/register', [RegisterController::class, 'show'])->name('register');
    Route::post('/register/validate', [RegisterController::class, 'validation'])->name('register.validate');
    Route::get('/register/resend-token', [RegisterController::class, 'resend_token'])->name('register.resend-token');
    Route::post('/register/resend-token/send', [RegisterController::class, 'send_token'])->name('register.resend-token.send');
    Route::get('/user/validate-email/{token}/{email}', [RegisterController::class, 'email_validate'])->name('register.email.validate');
});

Route::group(['middleware' => 'check.client:' . true], function () {
    /** USER PROFILE OR SETTINGS */
    Route::get('/profile', [ClientController::class, 'menu'])->name('profile');
    Route::post('/profile/edit', [ClientController::class, 'edit_profile'])->name('profile.edit');
    Route::get('/profile/change_password', [ClientController::class, 'showChangePassForm'])->name('profile.change_password');
    Route::post('/profile/change_password/validate', [ClientController::class, 'validatePass'])->name('profile.change_password.validate');
    // ADDRESS
    Route::get('/profile/address', [ClientController::class, 'address'])->name('profile.address');
    Route::get('/profile/address/create', [ClientController::class, 'address_create'])->name('address.create');
    Route::post('/profile/address/store', [ClientController::class, 'address_store'])->name('address.store');
    Route::post('/profile/address/delete', [ClientController::class, 'address_delete'])->name('address.delete');
    Route::get('/profile/address/edit/{id}', [ClientController::class, 'address_edit'])->name('address.edit');
    Route::post('/profile/address/update/{id}', [ClientController::class, 'address_update'])->name('address.update');
    Route::post('/profile/address/make_default', [ClientController::class, 'address_default'])->name('address.default');
    // RE-ORDERS
    Route::get('/orders/re-order/{id}', [ClientOrder::class, 're_order'])->name('orders.re-order');
    Route::post('/orders/re-order/{id}/place', [ClientOrder::class, 'place'])->name('orders.re-order.place');
    Route::get('/orders/update-location/{id}', [ClientOrder::class, 'showEditAddressForm'])->name('order.edit.address');
    Route::post('/orders/update-location/validate/{id}', [ClientOrder::class, 'checkEditAddress'])->name('order.edit.address.validate');    
});


// LOGOUT
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/logout/admin', [AuthController::class, 'logout_admin'])->name('logout.admin');

/** ORDER HISTORY */
Route::get('/orders', [ClientOrder::class, 'index'])->name('order_history');
Route::get('/orders/{id}', [ClientOrder::class, 'show'])->name('orders.show');

/** CHECKOUT */
Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
Route::post('/checkout/place_order', [CheckoutController::class, 'placeOrder'])->name('checkout.place_order');
Route::post('/checkout/upload', [CheckoutController::class, 'uploadAndExtractText'])->name('checkout.upload');

Route::get('/checkout/update-location', [CheckoutController::class, 'showEditAddressForm'])->name('checkout.edit.address');
Route::post('/checkout/update-location/validate', [CheckoutController::class, 'checkEditAddress'])->name('checkout.edit.address.validate');
Route::post('/checkout/default_address', [CheckoutController::class, 'makeDefaultAddress'])->name('checkout.default_address');



// ADMIN
Route::get('/administrator/login', [AuthController::class, 'show_admin'])->name('login.administrator');
Route::post('/administrator/authenticate', [AuthController::class, 'admin_auth'])->name('administrator.authenticate');


Route::get('/administrator/password/reset', [AuthController::class, 'showLinkRequestForm'])->name('admin.password.request');
Route::post('/administrator/password/email', [AuthController::class, 'sendResetLinkEmail'])->name('admin.password.email');
Route::get('/administrator/password/reset/{token}', [AuthController::class, 'showResetForm'])->name('admin.password.reset');
Route::post('/administrator/password/reset', [AuthController::class, 'resetAdminPassword'])->name('admin.password.new');

// Route::get('/administrator/password/reset', [AuthController::class, 'admin_reset_password'])->name('login.administrator.reset-password');
// Route::post('/administrator/password/reset/validate', [AuthController::class, 'admin_validate_rp'])->name('login.administrator.reset-password.validate');
// Route::get('/administrator/password/reset', [AuthController::class, 'reset_password_admin'])->name('login.administrator.new-password');
// DASHBOARD
Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
Route::get('/admin/dashboard/download-chart', [DashboardController::class, 'downloadChart'])->name('admin.dashboard.download-chart');
Route::post('/administrator/broadcast', [DashboardController::class, 'broadcast'])->name('admin.broadcast');

// STAFF
Route::group(['middleware' => 'check.access:staff_management'], function () {
    Route::get('/admin/staff', [StaffController::class, 'index'])->name('admin.staff.index');
    Route::post('/admin/staff/store', [StaffController::class, 'store'])->name('admin.staff.store');
    Route::post('/admin/staff/init', [StaffController::class, 'init'])->name('admin.staff.init');
    Route::post('/admin/staff/fetch', [StaffController::class, 'fetch'])->name('admin.staff.fetch');
    Route::post('/admin/staff/update', [StaffController::class, 'update'])->name('admin.staff.update');
    Route::get('/staff/password-setup/{token}', [StaffController::class, 'showPasswordSetupForm'])->name('admin.staff.setup');
    Route::post('/staff/password-setup/{token}', [StaffController::class, 'setupPassword'])->name('admin.staff.verify');
});

// BUFFALOS
Route::group(['middleware' => 'check.access:buffalo_management'], function () {
    Route::get('/admin/dairy', [DairyController::class, 'index'])->name('admin.dairy.index');
    Route::post('/admin/dairy/buffalo-update', [DairyController::class, 'buffalo_update'])->name('admin.dairy.buffalo-update');
    Route::post('/admin/dairy/buffalo-sell', [DairyController::class, 'buffalo_sell'])->name('admin.dairy.buffalo-sell');
    Route::post('/admin/dairy/buffalo-sales-fetch', [DairyController::class, 'buffalo_sales_fetch'])->name('admin.dairy.buffalo-sales-fetch');
    Route::post('/admin/dairy/buffalo-fetch', [DairyController::class, 'buffalo_fetch'])->name('admin.dairy.buffalo-fetch');
    Route::get('/admin/dairy/buffalo-invoice/{id}', [DairyController::class, 'buffalo_show'])->name('admin.dairy.buffalo-show');
    Route::get('/admin/dairy/print-invoice/{id}', [DairyController::class, 'printInvoice'])->name('admin.dairy.print-invoice');
});

//PRODUCTS (INVENTORY AND VARIANT)
Route::group(['middleware' => 'check.access:products'], function () {
    Route::get('/admin/products', [ProductController::class, 'index'])->name('admin.products.index');
    Route::get('/admin/products/print', [ProductController::class, 'print'])->name('admin.products.print');
    Route::get('/admin/products/{id}', [ProductController::class, 'show'])->name('admin.products.show');
    Route::post('/admin/products/data', [ProductController::class, 'getProductsData'])->name('admin.products.data');
    Route::post('/admin/products/update-status', [ProductController::class, 'updateStatus'])->name('admin.products.updateStatus');
    Route::post('/admin/products/add-stocks', [ProductController::class, 'addStocks'])->name('admin.products.addStocks');
    Route::post('/admin/products/store', [ProductController::class, 'store'])->name('admin.products.store');
    Route::post('/admin/products/update', [ProductController::class, 'update'])->name('admin.products.update');
    Route::post('/admin/variants/data', [VariantController::class, 'getVariantsData'])->name('admin.variants.data');
    Route::post('/admin/variants/store', [VariantController::class, 'store'])->name('admin.variants.store');
    Route::post('/admin/variants/update', [VariantController::class, 'update'])->name('admin.variants.update');
});

// ORDERS
Route::group(['middleware' => 'check.access:orders'], function () {
    Route::get('/admin/orders', [OrderManagement::class, 'index'])->name('admin.orders.index');
    Route::get('/admin/orders/print-invoce/{id}', [OrderManagement::class, 'printInvoice'])->name('admin.orders.print-invoice');
    Route::get('/admin/orders/create', [OrderManagement::class, 'create'])->name('admin.orders.create');
    Route::post('/admin/orders/create/customer', [OrderManagement::class, 'store_customer'])->name('admin.orders.create_customer_details');
    Route::post('/admin/orders/create/store_selected_products', [OrderManagement::class, 'selected_products'])->name('admin.orders.selected_products');
    // Route::post('/admin/orders/create/data', [OrderManagement::class, 'data'])->name('admin.orders.data');    
    Route::post('/admin/orders/create/populate_address', [OrderManagement::class, 'populate_address'])->name('admin.orders.populate_address');
    Route::post('/admin/orders/edit/customer', [OrderManagement::class, 'edit_customer'])->name('admin.orders.edit_customer_details');
    Route::post('/admin/orders/fetch/customer', [OrderManagement::class, 'fetch_customer'])->name('admin.orders.fetch_customer_details');
    Route::post('/admin/orders/get/customer', [OrderManagement::class, 'get_customer'])->name('admin.orders.get_customer_details');
    Route::post('/admin/orders/create/store', [OrderManagement::class, 'store_order'])->name('admin.orders.store_order');
    Route::post('/admin/orders/store', [OrderManagement::class, 'store'])->name('admin.orders.store');
    Route::get('/admin/orders/{id}', [OrderManagement::class, 'show'])->name('admin.orders.show');
    Route::post('/admin/orders/edit/ref', [OrderManagement::class, 'ref'])->name('admin.orders.ref');
    Route::post('/admin/orders/fetch', [OrderManagement::class, 'fetch'])->name('admin.orders.fetch');
    Route::put('/admin/orders/{id}/approved', [OrderManagement::class, 'approved'])->name('admin.orders.approved');
    Route::put('/admin/orders/{id}/otw', [OrderManagement::class, 'onTheWay'])->name('admin.orders.otw');
    Route::put('/admin/orders/{id}/pickup', [OrderManagement::class, 'pickUp'])->name('admin.orders.pick_up');
    Route::put('/admin/orders/{id}/delivered', [OrderManagement::class, 'delivered'])->name('admin.orders.delivered');
    Route::put('/admin/orders/{id}/reject', [OrderManagement::class, 'reject'])->name('admin.orders.reject');
});

// PAYMENT METHODS
Route::group(['middleware' => 'check.access:payment_methods'], function () {
    Route::get('/admin/payment_method', [PaymentMethodController::class, 'index'])->name('admin.payment_method.index');
    Route::post('/admin/payment_method/data', [PaymentMethodController::class, 'getPaymentMethodData'])->name('admin.payment_method.data');
    Route::post('/admin/payment_method/store', [PaymentMethodController::class, 'store'])->name('admin.payment_method.store');
    Route::post('/admin/payment_method/delete', [PaymentMethodController::class, 'delete'])->name('admin.payment_method.delete');
    Route::post('/admin/payment_method/status', [PaymentMethodController::class, 'status'])->name('admin.payment_method.status');
    Route::post('/admin/payment_method/update', [PaymentMethodController::class, 'update'])->name('admin.payment_method.update');
});

// ACTIVITY LOGS
Route::group(['middleware' => 'check.access:activity_logs'], function () {
    Route::get('/admin/activity_logs', [ActivityLogsController::class, 'index'])->name('admin.activity_logs');
});

// SALES REPORT
Route::group(['middleware' => 'check.access:sales_report'], function () {
    Route::get('/admin/sales_reports', [SalesReportController::class, 'index'])->name('admin.sales_report.index');
    Route::post('/admin/sales_reports/update-year', [SalesReportController::class, 'updateYear'])->name('admin.sales_report.update-year');
    Route::post('/admin/sales_reports/daily-sales', [SalesReportController::class, 'dailySales'])->name('admin.sales_report.daily-sales');
    Route::get('/admin/sales_reports/daily_sales/download-chart', [SalesReportController::class, 'downloadChart'])->name('admin.sales_reports.download-chart');
});

// PROFILE
Route::get('/admin/profile', [ProfileController::class, 'index'])->name('admin.profile.index');
Route::post('/admin/profile/update-password', [ProfileController::class, 'update_password'])->name('admin.profile.update-password');
