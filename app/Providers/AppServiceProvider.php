<?php

namespace App\Providers;

use App\Repositories\CustomerRepository;
use App\Repositories\Interface\CustomerRepositoryInterface;
use App\Repositories\Interface\OrderRepositoryInterface;
use App\Repositories\Interface\ProductRepositoryInterface;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use App\Services\BrandService;
use App\Services\CrawlerService;
use App\Services\CustomerService;
use App\Services\OrderService;
use App\Services\ProductService;
use App\Services\TypeService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CrawlerService::class, CrawlerService::class);
        $this->app->bind(BrandService::class, BrandService::class);
        $this->app->bind(TypeService::class, TypeService::class);

        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(ProductService::class, function ($app) {
            return new ProductService($app->make(ProductRepositoryInterface::class));
        });

        $this->app->bind(CustomerRepositoryInterface::class, CustomerRepository::class);
        $this->app->bind(CustomerService::class, function ($app) {
            return new CustomerService($app->make(CustomerRepositoryInterface::class));
        });

        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(OrderService::class, function ($app) {
            return new OrderService($app->make(OrderRepositoryInterface::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
