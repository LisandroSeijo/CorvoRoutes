<?php namespace Corvo\Routes\Providers;

use Corvo\Routes\Components\CorvoRoutes;
use Corvo\Routes\Commands\CreateSectionCommand;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

class CorvoRoutesServiceProvider extends ServiceProvider {
    
    public function register()
    {
        $this->app->bind('CorvoRoutes', function()
        {
            return new CorvoRoutes;
        });

        $this->app->booting(function()
        {
            $loader = AliasLoader::getInstance();
            $loader->alias('CorvoRoutes', 'Corvo\Routes\Facades\CorvoRoutesFacade');
        });

        $this->app['command.corvoroutes.createsection'] = $this->app->share(function($app)
        {
            return new CreateSectionCommand;
        });

        $this->commands('command.corvoroutes.createsection');
    }
}
