<?php

$api_route_prefix = config('badaso-graphql.prefix');

Route::group(
    [
        'prefix' => $api_route_prefix,
        'namespace' => 'Uasoft\Badaso\Module\Graphql\Controllers',
        'as' => 'badaso.module.graphql.',
        'middleware' => 'web',
    ],
);
