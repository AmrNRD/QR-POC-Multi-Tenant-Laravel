<?php

namespace App\Domain\Tenant\Employee\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Repositories Array With Interface as a Key and Eloquent as a Value.
     *
     * @var array
     */
    private $repositories = [
        \App\Domain\Tenant\Employee\Repositories\Contracts\EmployeeDevicesRepository::class => \App\Domain\Tenant\Employee\Repositories\Eloquent\EmployeeDevicesRepositoryEloquent::class,
			\App\Domain\Tenant\Employee\Repositories\Contracts\EmployeeRepository::class => \App\Domain\Tenant\Employee\Repositories\Eloquent\EmployeeRepositoryEloquent::class,
			\App\Domain\Tenant\Employee\Repositories\Contracts\EmployeeShiftRepository::class => \App\Domain\Tenant\Employee\Repositories\Eloquent\EmployeeShiftRepositoryEloquent::class,
			###REPOSITORIES_PLACEHOLDER###
		// Your Repos Here "interface => eloquent class"
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Bind all repositories to application.
         */
        foreach ($this->repositories as $interface => $eloquent) {
            $this->app->singleton($interface, $eloquent);
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array_keys($this->repositories);
    }
}
