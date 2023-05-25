<?php

require __DIR__ . '/../vendor/autoload.php';

$config['displayErrorDetails'] = true;
  
$app = new \Slim\App(["settings" => $config]);

$container = $app->getContainer();

require __DIR__ . '/../app/settings.php';

require __DIR__ . '/../app/routes/routes.php';

$app->run();