<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductDashboardController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Client\AuthController;
use App\Http\Controllers\Client\RegisterController;
use App\Http\Controllers\Client\OrderController;
use App\Http\Controllers\Client\PageController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\ShopController;
use App\Http\Controllers\Client\CheckoutController;

// use App\Http\Controllers\ProductController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
*/

/* HOME */
Route::get('/testing', function () {
    return view('test');
});

Route::get('/', [PageController::class, 'index'])->name('index');

Route::get('/about', [PageController::class, 'about'])->name('about');

Route::get('/contact', [PageController::class, 'contact'])->name('contact');

Route::get('/terms', [PageController::class, 'terms'])->name('terms');

Route::get('/faqs', [PageController::class, 'faqs'])->name('faqs');

Route::get('/payment', [PageController::class, 'payment']);

Route::get('/detail', [PageController::class, 'detail']);

/** CART MANAGEMENT */
Route::get('/cart', [CartController::class, 'cart'])->name('cart');
Route::patch('/cart/{id}/update', [CartController::class, 'updateQuantity']);
Route::delete('/cart/{id}/remove', [CartController::class, 'removeCartItem']);
Route::get('/cart/count', [CartController::class, 'getCartCount']);

/** SHOP */
Route::get('/shop/products', [ShopController::class, 'show'])->name('shop');
Route::get('/shop/product/{id}', [ShopController::class, 'addToCartForm'])->name('product.view');
Route::post('/shop/product/add/{productId}', [ShopController::class, 'addToCart'])->name('product.add');

/** AUTHENTICATION */
Route::get('/login', [AuthController::class, 'show'])->name('login');
Route::post('/login/authenticate', [AuthController::class, 'authenticate'])->name('authenticate');
Route::get('/administrator/login', [AuthController::class, 'show_admin'])->name('login.administrator');
Route::post('/administrator/authenticate', [AuthController::class, 'admin_auth'])->name('administrator.authenticate');
Route::get('/reset-password', [AuthController::class, 'resetPasswordForm'])->name('reset_password');
Route::post('/check-reset-password-form', [AuthController::class, 'checkRPForm'])->name('reset_password.check');
Route::post('/verify-reset-password-form', [AuthController::class, 'verifyRPForm'])->name('reset_password.verify');
Route::get('/reset-password/{number}', [AuthController::class, 'newPasswordForm'])->name('reset_password.newpassword');
Route::post('/reset-password/{number}/verify', [AuthController::class, 'verifyNewPass'])->name('reset_password.verify_newpassword');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/logout/admin', [AuthController::class, 'logout_admin'])->name('logout.admin');

/**REGISTER */
Route::get('/register', [RegisterController::class, 'show'])->name('register');
Route::post('/check-mobile-number', [RegisterController::class, 'checkMobileNum'])->name('register.validate');
Route::post('/input-mobile-number', [RegisterController::class, 'InputMobileNum']);
Route::get('/register-details/number/{mobile_number}', [RegisterController::class, 'showDetailsForm'])->name('register.details.page');
Route::post('register/details/validate', [RegisterController::class, 'checkDetails'])->name('register.details.validate');

/** ORDER HISTORY */
Route::get('/order', [OrderController::class, 'show'])->name('order_history');

/** CHECKOUT */
Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
Route::get('/checkout/edit_address', [CheckoutController::class, 'showEditAddressForm'])->name('checkout.edit_address');
Route::post('/checkout/edit_address/validate', [CheckoutController::class, 'checkEditAddress'])->name('checkout.edit_address.validate');
Route::post('/checkout/default_address', [CheckoutController::class, 'makeDefaultAddress'])->name('checkout.default_address');
Route::post('/checkout/place_order', [CheckoutController::class, 'placeOrder'])->name('checkout.place_order');

/** USER PROFILE OR SETTINGS */
Route::get('/profile', [ClientController::class, 'menu'])->name('profile');
Route::post('/profile/edit/name', [ClientController::class, 'editName'])->name('edit.name');

Route::get('/profile/change_password', [ClientController::class, 'showChangePassForm'])->name('profile.change_password');
Route::post('/profile/change_password/validate', [ClientController::class, 'validatePass'])->name('profile.change_password.validate');

Route::get('/profile/address', [ClientController::class, 'address'])->name('profile.address');
Route::post('/profile/create_address', [ClientController::class, 'createAddress'])->name('create.address');
Route::delete('/profile/address/delete/{id}', [ClientController::class, 'deleteAddress'])->name('delete.address');
Route::get('/profile/address/edit/{id}', [ClientController::class, 'editAddress'])->name('edit.address');
Route::put('/profile/address/update/{id}', [ClientController::class, 'updateAddress'])->name('update.address');
Route::post('/profile/address/make_default', [ClientController::class, 'defaultAddress'])->name('default.address');

Route::get('/profile/email', [ClientController::class, 'EmailForm'])->name('email.form');
Route::get('/profile/change-email', [ClientController::class, 'ChangeEmailForm'])->name('email.change-show');
Route::get('/profile/email/verify', [ClientController::class, 'EmailVerifyShow'])->name('email.show');
Route::post('/profile/change-email/verify', [ClientController::class, 'ChangeEmail'])->name('email.change');
Route::post('/profile/create/email', [ClientController::class, 'createEmail'])->name('email.create');
Route::post('/profile/email/resend_code', [ClientController::class, 'resendMail'])->name('email.resend');
Route::get('/verify-email/{token}/{email}', [ClientController::class, 'verifyEmail'])->name('email.verify');

// ADMIN

Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

Route::get('/admin/products', [ProductController::class, 'index'])->name('admin.products.index');
Route::get('/admin/products/create', [ProductController::class, 'create'])->name('admin.products.create');
Route::post('/admin/products/store', [ProductController::class, 'store'])->name('admin.products.store');
Route::get('/admin/variants', [ProductController::class, 'variants'])->name('admin.products.variants');
Route::post('/admin/variants/store', [ProductController::class, 'variants_store'])->name('admin.products.variants.store');
Route::get('/admin/products/{product}', [ProductController::class, 'show'])->name('admin.products.show');
Route::get('/admin/products/{product}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
Route::put('/admin/products/{product}', [ProductController::class, 'update'])->name('admin.products.update');
Route::get('/admin/products/stock/{product}', [ProductController::class, 'stock'])->name('admin.products.stock');
Route::post('/admin/products/stock/{product}/store', [ProductController::class, 'stock_store'])->name('admin.products.stock.store');
Route::post('/admin/products/stock/add', [ProductController::class, 'addStock'])->name('admin.product.addStock');
Route::get('/admin/products/stock/{productId}', [ProductDashboardController::class, 'getStockData'])->name('admin.products.stock.data');
Route::resource('products', ProductsController::class);