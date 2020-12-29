<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use Monolog\Logger;

return function (ContainerBuilder $containerBuilder) {
    // Global Settings Object
    $containerBuilder->addDefinitions([
        'settings' => [
            'displayErrorDetails' => true,
            'logger' => [
                'name' => 'task-app',
                'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
                'level' => Logger::DEBUG,
            ],
            'db' => [
                'host' => $_ENV['DB_HOST'],
                'port' => $_ENV['DB_PORT'],
                'name' => $_ENV['DB_DATABASE'],
                'user' => $_ENV['DB_USERNAME'],
                'pass' => $_ENV['DB_PASSWORD'],
            ]
        ],
    ]);
};
