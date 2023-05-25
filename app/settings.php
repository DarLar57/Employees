<?php

use \Models\DB;

$container['view'] = new \Slim\Views\PhpRenderer("../app/templates/");

$container['logger'] = function($c) {
    $logger = new \Monolog\Logger('my_logger');
    $file_handler = new \Monolog\Handler\StreamHandler("../app/logs/app.log");
    $logger->pushHandler($file_handler);
    return $logger;
};

$container['db'] = DB::getPDO();