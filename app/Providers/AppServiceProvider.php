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
        Schema::disableForeignKeyConstraints();

        //
        //Model::unguard();

        View::composer('layouts.client', function ($view) use ($request) {
            if (auth()->check()) {
                $user = User::with('cart.product')->where('id', auth()->user()->id)->first();
                $carts = $user->cart->where('order_number', NULL);
                $cartCount = $carts->count();
                $cartTotal = $carts->sum('total');
            } else {
                $identifier = $request->cookie('device_identifier');
                $guest = GuestUser::where('guest_identifier', $identifier)->first();
    
                if (!$guest) {
                    // Create a new guest user if it doesn't exist
                    $guest = new GuestUser();
                    $guest->guest_identifier = $identifier;
                    $guest->save();
                }
    
                $guestCart = GuestUser::with('guest_cart.product')->where('id', $guest->id)->first();
                $carts = $guestCart->guest_cart->where('order_number', NULL);
                $cartCount = $carts->count();
                $cartTotal = $carts->sum('total');
            }
            $view->with(['cartCount' => $cartCount, 'carts' => $carts, 'cartTotal' => $cartTotal]);
        });
    }
}
