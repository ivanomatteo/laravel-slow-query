<?php

namespace IvanoMatteo\LaravelSlowQuery;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use IvanoMatteo\LaravelSlowQuery\Events\SlowQueryDetected;

class LaravelSlowQueryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/LaravelSlowQuery.php', 'laravel-slow-query');

        $this->publishConfig();

        // $this->loadViewsFrom(__DIR__.'/resources/views', 'laravel-slow-query');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->registerRoutes();

        DB::listen(function (?QueryExecuted $query) {

            if ($query->time > config('laravel-slow-query.max-time')) {
                $escapedBindings = collect($query->bindings)->map(function ($item, $key) {
                    return DB::connection()->getPdo()->quote($item);
                })->toArray();
                $sqlPreview = Str::replaceArray('?', $escapedBindings, $query->sql);

                $report = [
                    'sql' => $query->sql,
                    'bindings' => $query->bindings,
                    'sqlPreview' => $sqlPreview,
                    'time' => $query->time,
                ];

                SlowQueryDetected::dispatch($report);
            }
        });
    }

    /**
     * Register the package routes.
     *
     * @return void
     */
    private function registerRoutes()
    {
       /*  Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__ . '/Http/routes.php');
        }); */
    }

    /**
    * Get route group configuration array.
    *
    * @return array
    */
    private function routeConfiguration()
    {
        return [
            'namespace'  => "IvanoMatteo\LaravelSlowQuery\Http\Controllers",
            'middleware' => 'api',
            'prefix'     => 'api'
        ];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Register facade
        /* $this->app->singleton('laravel-slow-query', function () {
            return new LaravelSlowQuery;
        }); */
    }

    /**
     * Publish Config
     *
     * @return void
     */
    public function publishConfig()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/LaravelSlowQuery.php' => config_path('LaravelSlowQuery.php'),
            ], 'config');
        }
    }
}
