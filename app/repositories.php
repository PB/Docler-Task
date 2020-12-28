<?php
declare(strict_types=1);

use App\Domain\User\UserRepository;
use App\Infrastructure\Persistence\Postgresql\Connection;
use App\Infrastructure\Persistence\User\PostgresqlUserRepository;
use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        UserRepository::class => function (ContainerInterface $c) {
            $connection = $c->get(Connection::class);

            return new PostgresqlUserRepository($connection);
        }
    ]);
};
