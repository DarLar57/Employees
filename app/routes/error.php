<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

//getting error message dependant on kind of error
$app->get('/error/{txt}', function (Request $request, Response $response, $args) {
    $txt = $args['txt'];
    $response = $this->view->render($response, "error.php", ["txt" => $txt, "router" => $this->router]);

    return $response;
});