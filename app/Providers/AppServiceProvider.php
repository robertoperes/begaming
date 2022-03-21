<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
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
        Builder::macro(
            'paginateWithLimit',
            function ($perPage = 15, $page = 1, $column = ['*'], $opt = []): LengthAwarePaginator {
                $total = $this->toBase()->getCountForPagination($column);
                $items = $this->forPage($page, $perPage)->get();

                return new LengthAwarePaginator($items, $total, $perPage, $page, $opt);
            }
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
