<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Accessibility;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        
		Gate::define('check-access', function ($user, $module, $action) {
				
			$permission = Accessibility::where('role_id', $user->role	)
				->where('module', $module)
				->where('action', $action)
				->where('access', 1)
				->first();
				
			return $permission ? true : false;
		});
    }
}
