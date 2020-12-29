<?php
declare(strict_types=1);

namespace App\Application\Listeners\Task;

use App\Domain\Task\Event\TasksListViewed;
use League\Event\Listener;
use Psr\Log\LoggerInterface;

/**
 * Class TasksListViewedListener
 * @package App\Application\Listeners\Task
 */
class TasksListViewedListener implements Listener
{
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * TasksListViewedListener constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {

        $this->logger = $logger;
    }

    /**
     * @param TasksListViewed $event
     */
    public function __invoke(object $event): void
    {
        $this->logger->info("Tasks list of user {$event->getUser()->getUsername()} was viewed.");
    }
}
