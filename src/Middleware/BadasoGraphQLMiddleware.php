<?php

namespace Uasoft\Badaso\Module\Graphql\Middleware;

use Closure;
use Illuminate\Http\Request;

class BadasoGraphQLMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        return $response;
    }
}
