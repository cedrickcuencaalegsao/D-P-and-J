<?php

namespace App\Providers;

use App\Domain\Category\CategoryRepository;
use App\Domain\Product\ProductRepository;
use App\Domain\Sale\SaleRepository;
use App\Domain\Stock\StockRepository;
use App\Domain\User\UserRepository;
use App\Infrastructure\Persistence\Eloquent\Category\EloquentCategoryRepository;
use App\Infrastructure\Persistence\Eloquent\Product\EloquentProductRepository;
use App\Infrastructure\Persistence\Eloquent\Sales\EloquentSalesRepository;
use App\Infrastructure\Persistence\Eloquent\Stock\EloquentStockRepository;
use App\Infrastructure\Persistence\Eloquent\User\EloquentUserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // for users.
        $this->app->bind(UserRepository::class, EloquentUserRepository::class);
        // for products.
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
