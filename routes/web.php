<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Client\AuthController;
use App\Http\Controllers\Client\RegisterController;
use App\Http\Controllers\Client\OrderController;
use App\Http\Controllers\Client\ResetPassController;
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

Route::get('/buyer/forgot_password', [ResetPassController::class, 'show'])->name('forgot_password');
Route::post('/buyer/forgot_password/validate', [ResetPassController::class, 'checkMobileNum'])->name('forgot_password.validate');

Route::get('/buyer/reset', [ResetPassController::class, 'showOTPForm'])->name('forgot_password.otp');
Route::post('buyer/reset/validate', [ResetPassController::class, 'checkOTP'])->name('forgot_password.otp.validate');
Route::post('/buyer/reset/resend', [ResetPassController::class, 'resendOTP'])->name('forgot_password.otp.resend');

Route::get('/buyer/reset/new_password', [ResetPassController::class, 'showResetPassForm'])->name('forgot_password.reset');
Route::post('/buyer/reset/new_password/validate', [ResetPassController::class, 'checkNewPass'])->name('forgot_password.reset.validate');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

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
Route::get('/profile/address/edit', [ClientController::class, 'editAddress'])->name('edit.address');
Route::post('/profile/address/edit/validate', [ClientController::class, 'updateAddress'])->name('edit.address.validate');
Route::post('/profile/address/make_default', [ClientController::class, 'defaultAddress'])->name('default.address');

Route::post('/profile/create/email', [ClientController::class, 'createEmail'])->name('email.create');
Route::post('/profile/email/resend_code', [ClientController::class, 'resendMail'])->name('email.resend');
Route::get('/verify-email/{token}', [ClientController::class, 'verifyEmail'])->name('email.verify');






// ADMIN
Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
Route::get('/admin/products', [ProductController::class, 'index'])->name('admin.products.index');
Route::get('/admin/products/create', [ProductController::class, 'create'])->name('admin.products.create');
Route::post('/admin/products', [ProductController::class, 'store'])->name('admin.products.store');
Route::get('/admin/products/{product}', [ProductController::class, 'show'])->name('admin.products.show');
Route::get('/admin/products/{product}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
Route::put('/admin/products/{product}', [ProductController::class, 'update'])->name('admin.products.update');