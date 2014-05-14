<?php namespace Corvo\Routes\Facades;

use Illuminate\Support\Facades\Facade;

class CorvoRoutesFacade extends Facade {
    
    protected static function getFacadeAccessor() 
    { 
        return 'CorvoRoutes'; 
    }
}
