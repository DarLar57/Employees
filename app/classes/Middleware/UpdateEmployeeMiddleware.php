<?php

namespace Models\Middleware;

class UpdateEmployeeMiddleware
{
    public function __invoke($request, $response, $next)
    {
        {
            $route = $request->getAttribute('route');

            $data = $route->getArgument('first_name') . " " . $route->getArgument('last_name');

            $response = $next($request, $response);
            $response->getBody()->write('<h3>Employee <span style="color: red">(' . $data . ') </span> has just been updated !</h3>');
            
            return $response;
        }
    }
}