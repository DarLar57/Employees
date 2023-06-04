<?php

namespace Models\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class AddEmployeeMiddleware
{
    public function __invoke(Request $request, Response $response, callable $next)
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