<?php

namespace App\Providers;

use App\Customer;
use App\Order;
use App\Product;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*',function($view){
        $app_product = Product::all()->count();
        $app_order = Order::all()->count();
        $app_customer = Customer::all()->count();

        $view->with(compact('app_product','app_order','app_customer'));
        });
    }
}
