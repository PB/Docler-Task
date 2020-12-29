<?php
declare(strict_types=1);

use App\Application\Listeners\Task\TasksListViewedListener;
use App\Domain\Task\Event\TasksListViewed;
use DI\ContainerBuilder;
use League\Event\EventDispatcher;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        EventDispatcher::class => function (ContainerInterface $c) {
            $dispatcher = new EventDispatcher();
            $listener = new TasksListViewedListener($c->get(LoggerInterface::class));

            $dispatcher->subscribeTo(TasksListViewed::class, $listener);
            return $dispatcher;
        },
    ]);

};
