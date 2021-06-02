<?php

namespace Uasoft\Badaso\Module\Graphql\Facades;

use Illuminate\Support\Facades\Facade;

class BadasoGraphqlModule extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'badaso-graphql-module';
    }
}
