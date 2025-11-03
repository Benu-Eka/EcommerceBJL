<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use App\Models\Cart;
use Illuminate\Support\ServiceProvider;

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
    public function boot(): void
    {
        View::composer('components.navbar', function ($view) {
            $pelangganId = auth('pelanggan')->id();
            $cartTotal = 0;

            if ($pelangganId) {
                $cartTotal = Cart::where('pelanggan_id', $pelangganId)->sum('jumlah');
            }

            $view->with('cartTotal', $cartTotal);
        });
    }
}
