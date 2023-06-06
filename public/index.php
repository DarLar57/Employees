<?php

require __DIR__ . '/../vendor/autoload.php';

use \App\Models\BaseOperations;

$settings = require __DIR__ . '/../app/config/settings.php';
  
$app = new \Slim\App($settings);

$container = $app->getContainer();

$dbSet = $container->get('settings')['db'];

$dsn = "{$dbSet['driver']}:host={$dbSet['host']};dbname={$dbSet['dbname']};charset={$dbSet['charset']}";

$container['db'] = new PDO($dsn, $dbSet['user'], $dbSet['password']);

$dbObj = new BaseOperations($container['db']);

$container['dbObj'] = $dbObj;

$container['view'] = new \Slim\Views\PhpRenderer("../app/templates/");

$container['logger'] = function($c) {
    $logger = new \Monolog\Logger('my_logger');
    $file_handler = new \Monolog\Handler\StreamHandler("../app/logs/app.log");
    $logger->pushHandler($file_handler);
    return $logger;
};
/*
$container['errorHandler'] = function ($container) {
    return function ($request, $response, $exception) use ($container) {
        return $response->withStatus(500)
            ->withHeader('Content-Type', 'text/html')
            ->write('Something went wrong!');
    };
};
*/

require __DIR__ . '/../app/routes/routes.php';

$app->run();