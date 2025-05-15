<?php

namespace App\Providers;

use App\Http\Middleware\CheckRole;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;

class RoleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Register route middleware
        Route::aliasMiddleware('role', CheckRole::class);

        // Add Blade directives for roles
        Blade::directive('role', function ($role) {
            return "<?php if(auth()->check() && auth()->user()->hasRole({$role})): ?>";
        });

        Blade::directive('endrole', function () {
            return "<?php endif; ?>";
        });

        Blade::directive('admin', function () {
            return "<?php if(auth()->check() && auth()->user()->isAdmin()): ?>";
        });

        Blade::directive('endadmin', function () {
            return "<?php endif; ?>";
        });

        Blade::directive('instructor', function () {
            return "<?php if(auth()->check() && auth()->user()->isInstructor()): ?>";
        });

        Blade::directive('endinstructor', function () {
            return "<?php endif; ?>";
        });

        Blade::directive('student', function () {
            return "<?php if(auth()->check() && auth()->user()->isStudent()): ?>";
        });

        Blade::directive('endstudent', function () {
            return "<?php endif; ?>";
        });
    }
}