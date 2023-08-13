<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\GuestUser;
use App\Models\GuestCart;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(Request $request): void
    {

        //
        //Model::unguard();

        View::composer('layouts.client', function ($view) {
            $user = null;
            if (auth()->check()) {
                $user = User::with('cart.product')->where('id', auth()->user()->id)->first();
                $carts = $user->cart->where('order_number', NULL);
                $cartTotal = $carts->sum('total');
                $cartCount = $carts->count();
            } else {
                $dataArray = session()->has('order_data') ? session('order_data') : [];

                $cartTotal = 0;
                foreach ($dataArray as $item) {
                    $cartTotal += $item['total'];
                }

                $carts = $dataArray;
                $cartCount = count($dataArray);
                
            }

            $view->with(compact('carts', 'cartTotal', 'cartCount', 'user'));
        });
    }
}
