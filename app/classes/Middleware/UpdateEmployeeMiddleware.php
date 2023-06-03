<?php

namespace Models\Middleware;

use Psr\Http\Message\ServerRequestInterface as request;
use Psr\Http\Message\ResponseInterface as response;

class UpdateEmployeeMiddleware
{
    public function __invoke(request $request, response $response, callable $next)
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