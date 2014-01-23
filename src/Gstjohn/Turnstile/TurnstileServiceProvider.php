<?php namespace Gstjohn\Turnstile;

use Illuminate\Support\ServiceProvider;

class TurnstileServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('gstjohn/turnstile');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'Gstjohn\Turnstile\Permission\PermissionInterface',
            'Gstjohn\Turnstile\Permission\IlluminatePermission'
        );

        $this->app->bind('turnstile', function () {
            return new Turnstile(
                $this->app->make('Gstjohn\Turnstile\Permission\PermissionInterface')
            );
        });
    }
}
