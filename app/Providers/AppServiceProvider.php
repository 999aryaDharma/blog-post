<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\View;
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
    public function boot()
    {
        View::composer('posts', function ($view) {
            // ambil semua user
            $users = User::all();

            // Ambil semua kategori dan acak urutannya
            $categories = Category::all()->shuffle();

            // Ambil hanya 4 kategori acak untuk ditampilkan di index
            $visibleCategories = $categories->take(4);

            // Ambil sisa kategori yang tidak ditampilkan
            $sisaCategories = $categories->slice(4);

            // Mengirimkan data ke view
            $view->with('visibleCategories', $visibleCategories)
                ->with('sisaCategories', $sisaCategories)
                ->with('users', $users);
        });
    }
}
