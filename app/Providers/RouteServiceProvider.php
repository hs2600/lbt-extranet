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
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/collections';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        RateLimiter::for('global', function (Request $request) {
            return Limit::perMinute(100);
        });

        RateLimiter::for('dealer-locator', function (Request $request) {
            $per_minute = 10;

            return Limit::perMinute($per_minute)->response(function (Request $request, array $headers) {
                return response('<h2>Too many requests. Please slow down!</h2> <h3>Wait one minute and try again (F5).</h3>', 429, $headers);
            });
        });

        RateLimiter::for('dealer-locator-lbt', function (Request $request) {
            $per_minute = 5;

            return Limit::perMinute($per_minute)->response(function (Request $request, array $headers) {
                return response('
                <div style="max-width: 400px;">
                    <h5 style="font-size: 1.35rem; margin-bottom: 15px; font-family: "Nunito", sans-serif;">
                    <b>LBT Authorized Dealers</b>
                    </h5>
                    <div style="border: 1px solid #999;
                    padding: 15px;
                    border-radius: 5px;
                    background-color: #f8f9fa;">
                    <h2 style="margin: 0px;">Too many requests!</h2>
                    <h3 style="padding: 10px 0px; margin: 0px;">Wait one minute and try again.</h3>
                    <button style="padding: 5px;" onClick="window.location.reload();">Refresh Page</button>
                    </div>
                </div>
                ', 429, $headers);
            });
        });

        RateLimiter::for('dealer-locator-api', function (Request $request) {
            $per_minute = 5;

            return Limit::perMinute($per_minute)->response(function (Request $request, array $headers) {
                return response()->json([
                    'message' => 'Too many attempts, please slow down the request.',
                    'status' => false
                ], 201);
            });
        });
    }
}
