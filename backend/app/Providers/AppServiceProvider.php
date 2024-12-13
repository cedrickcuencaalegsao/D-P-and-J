<?php

namespace App\Providers;

use App\Domain\Category\CategoryRepository;
use App\Domain\Product\ProductRepository;
use App\Domain\Sale\SaleRepository;
use App\Domain\Stock\StockRepository;
use App\Domain\User\UserRepository;
use Illuminate\Support\ServiceProvider;
use App\Infrastructure\Persistence\Eloquent\User\EloquentUserRepository;
use App\Infrastructure\Persistence\Eloquent\Category\EloquentCategoryRepository;
use App\Infrastructure\Persistence\Eloquent\Product\EloquentProductRepository;
use App\Infrastructure\Persistence\Eloquent\Sales\EloquentSalesRepository;
use App\Infrastructure\Persistence\Eloquent\Stock\EloquentStockRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepository::class, EloquentUserRepository::class);
        $this->app->bind(ProductRepository::class, EloquentProductRepository::class);
        $this->app->bind(CategoryRepository::class, EloquentCategoryRepository::class);
        $this->app->bind(SaleRepository::class, EloquentSalesRepository::class);
        $this->app->bind(StockRepository::class, EloquentStockRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
