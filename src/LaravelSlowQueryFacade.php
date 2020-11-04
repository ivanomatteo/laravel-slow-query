<?php

namespace IvanoMatteo\LaravelSlowQuery;

use Illuminate\Support\Facades\Facade;

class LaravelSlowQueryFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-slow-query';
    }
}
