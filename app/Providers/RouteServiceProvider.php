<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {

            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('api')
            ->namespace(value:$this->namespace)
            ->prefix('building')
            ->group(base_path('routes/building.php'));


            Route::middleware('api')
            ->namespace(value:$this->namespace)
            ->prefix('floor')
            ->group(base_path('routes/floor.php'));

            Route::middleware('api')
            ->namespace(value:$this->namespace)
            ->prefix('stage')
            ->group(base_path('routes/stage.php'));

            Route::middleware('api')
            ->namespace(value:$this->namespace)
            ->prefix('class')
            ->group(base_path('routes/class.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
