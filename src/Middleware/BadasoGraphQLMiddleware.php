<?php

namespace Uasoft\Badaso\Module\Graphql\Middleware;

use Closure;
use Illuminate\Http\Request;

class BadasoGraphQLMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $path_url = $request->path();
        switch ($path_url) {
            case $this->pathAccess('/v1/crud/add'):

                break;

            default:
                // code...
                break;
        }

        return $response;
    }

    private function pathAccess($path)
    {
        $api_route_prefix = config('badaso.api_route_prefix');
        $path = "{$api_route_prefix}{$path}";

        return $path;
    }
}
