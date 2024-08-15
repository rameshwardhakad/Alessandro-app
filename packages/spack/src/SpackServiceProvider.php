<?php

namespace Spack;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laranext\Span\Span;
use Spack\Http\Controllers\Api\CacheCleanup;
use Spack\Http\Controllers\Api\InstallationRecipe;
use Spack\Http\Controllers\Api\PingUpdate;
use Spack\Http\Middleware\TenantMiddleware;

class SpackServiceProvider extends ServiceProvider
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
                base_path('packages/spack/resources/views'),
            ]);

            return $view;
        });
    }

    /**
     * Boot the package routes.
     */
    protected function bootRoutes(): void
    {
        Route::post('ping-for-update', PingUpdate::class);
        Route::get('cache-cleanup-forcefully', CacheCleanup::class);
        Route::post('installation-recipe', InstallationRecipe::class);

        Route::group([
            'middleware' => ['web', 'auth', TenantMiddleware::class],
            'prefix' => Span::prefix().'/api',
        ], function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
        });

        Route::group([
            'middleware' => ['web', 'auth', TenantMiddleware::class],
            'prefix' => Span::prefix(),
        ], function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });
    }
}
