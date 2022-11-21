<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Page;
use DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Cashier;
use Torann\Currency\Currency;
use View;

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
        View::composer(['layout.header','admin.categories.categories','admin.products.index','admin.products.form','admin.products.create'], function($view)
        {
            $categories   = [];//Category::tree();
            $pages_menu   = Page::tree();
            $currencies   = currency()->getActiveCurrencies();
            $view->with('pages_menu', $pages_menu)->with('categories',$categories)->with('currencies',$currencies);
        });

        View::composer(['layout.footer'], function($view)
        {
            $info_menu     = Page::getChildren();
            $foot_pages    = Page::footMenu();
            $view->with('info_menu',$info_menu)->with('foot_pages',$foot_pages);
        });

        $settings=DB::table('settings')->get()->pluck('value', 'key');
        foreach ($settings as $key => $value)
        {
            if(defined($key) === false)
                define($key,$value);
        }

        Paginator::useBootstrap();

        Cashier::useCustomerModel(Vendor::class);
    }
}
