<?php

namespace Billing;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laranext\Span\Span;

class BillingServiceProvider extends ServiceProvider
{
    /**
     * Register any package services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any package services.
     */
    public function boot(): void
    {
        $this->bootRoutes();
        $this->bootResources();
    }

    /**
     * Boot the package resources.
     */
    protected function bootResources(): void
    {
        $this->app->extend('view', function ($view) {
            $view->getFinder()->setPaths([
                base_path('packages/billing/resources/views'),
            ]);

            return $view;
        });
    }

    /**
     * Boot the package routes.
     */
    protected function bootRoutes(): void
    {
        Route::group([
            'middleware' => ['web', 'auth'],
            'prefix' => Span::prefix().'/api',
        ], function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
        });

        Route::group([
            'middleware' => ['web', 'auth'],
            'prefix' => Span::prefix(),
        ], function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });
    }
}
