<?php

$graphql_prefix = \config('badaso-graphql.graphql_prefix_route');
$graphql_middleware = \config('badaso-graphql.middleware');

Route::group(
    [
        'prefix' => $graphql_prefix,
        'namespace' => 'Uasoft\Badaso\Module\Graphql\Controllers',
        'as' => 'badaso-graphql.',
        'middleware' => $graphql_middleware,
    ],
    function () {
        Route::group(['prefix' => 'v1'], function () {
            Route::post('/', 'BadasoGraphqlController@graphql');
        });
    }
);
