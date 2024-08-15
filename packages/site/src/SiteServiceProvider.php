<?php

namespace Site;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laranext\Span\Span;

class SiteServiceProvider extends ServiceProvider
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
                base_path('packages/site/resources/views'),
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
            'middleware' => 'web',
            'prefix' => Span::prefix(),
        ], function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });
    }
}
