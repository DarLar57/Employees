<?php

return [
    'settings' => [
        'db' => [
            'driver' => 'mysql',
            'host' => 'localhost',
            'dbname' => 'iwq',
            'user' => 'root',
            'password' => '',
            'charset' => 'utf8mb4',
            'flags' => [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ],
        ],
        'displayErrorDetails' => true,
    ],
];