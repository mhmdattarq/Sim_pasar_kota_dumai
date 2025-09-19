<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

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
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();

                // Cek data pedagang
                $pedagang = DB::table('pedagangregister')
                    ->where('user_id', $user->id)
                    ->first();

                $displayName = $pedagang->nama ?? ($user->username ?? $user->nik);

                $view->with('displayName', $displayName);
            }
        });
    }
}