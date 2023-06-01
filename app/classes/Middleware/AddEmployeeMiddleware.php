<?php

namespace Models\Middleware;

class AddEmployeeMiddleware
{
    public function __invoke($request, $response, $next)
    {
        {
            $route = $request->getAttribute('route');

            $data = $route->getArgument('first_name') . " " . $route->getArgument('last_name');

            $response = $next($request, $response);
            $response->getBody()->write('<h3>New employee <span style="color: red">(' . $data . ') </span> has just been registerred !</h3>');
            
            return $response;
        }
    }
}