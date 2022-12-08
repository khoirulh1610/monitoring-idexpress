<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Paket;
        

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
        
        $paketgagal = Paket::whereIn('operationType', ['18','19'])->take(7)->orderBy('last_cek_at','desc')->get();
        $gagal7 = Paket::whereIn('operationType', ['18','19'])->take(7)->orderBy('last_cek_at','desc')->count();
        View::share('paketgagal',$paketgagal);
        view::share('gagal7',$gagal7);
    }
}
