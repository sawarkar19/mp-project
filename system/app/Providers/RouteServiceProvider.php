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
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));

            Route::middleware(['web', 'admin'])
                ->namespace('App\Http\Controllers\Admin')
                ->prefix('admin')
                ->group(base_path('routes/admin.php'));

            Route::middleware(['web', 'seo'])
                ->namespace('App\Http\Controllers\Seo')
                ->prefix('seo')
                ->group(base_path('routes/seo.php'));

            Route::middleware(['web', 'business'])
                ->namespace('App\Http\Controllers\Business')
                ->prefix('business')
                ->group(base_path('routes/business.php'));

            Route::middleware(['web', 'employee'])
                ->namespace('App\Http\Controllers\Employee')
                ->prefix('employee')
                ->group(base_path('routes/employee.php'));

            Route::middleware(['web', 'account'])
                ->namespace('App\Http\Controllers\Account')
                ->prefix('account')
                ->group(base_path('routes/account.php'));

            Route::middleware(['web', 'seomanager'])
                ->namespace('App\Http\Controllers\SeoManager')
                ->prefix('seomanager')
                ->group(base_path('routes/seomanager.php')); 
                
            Route::middleware(['web', 'support'])
                ->namespace('App\Http\Controllers\Support')
                ->prefix('support')
                ->group(base_path('routes/support.php'));

            Route::middleware(['web', 'designer'])
                ->namespace('App\Http\Controllers\Designer')
                ->prefix('designer')
                ->group(base_path('routes/designer.php'));

            Route::middleware(['web', 'wacloud'])
                ->namespace('App\Http\Controllers\WaCloud')
                ->prefix('wacloud')
                ->group(base_path('routes/wacloud.php'));

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
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
