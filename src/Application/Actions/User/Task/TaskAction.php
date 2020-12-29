<?php
declare(strict_types=1);

namespace App\Application\Actions\User\Task;

use App\Application\Actions\Action;
use App\Domain\Task\TaskRepository;
use App\Domain\User\UserRepository;
use League\Event\EventDispatcher;
use Psr\Log\LoggerInterface;

abstract class TaskAction extends Action
{
    /**
     * @var UserRepository
     */
    protected UserRepository $userRepository;
    /**
     * @var TaskRepository
     */
    protected TaskRepository $taskRepository;
    /**
     * @var EventDispatcher
     */
    protected EventDispatcher $eventDispatcher;

    /**
     * @param LoggerInterface $logger
     * @param UserRepository $userRepository
     * @param TaskRepository $taskRepository
     * @param EventDispatcher $eventDispatcher
     */
    public function __construct(
        LoggerInterface $logger,
        UserRepository $userRepository,
        TaskRepository $taskRepository,
        EventDispatcher $eventDispatcher
    ) {
        parent::__construct($logger);
        $this->userRepository = $userRepository;
        $this->taskRepository = $taskRepository;
        $this->eventDispatcher = $eventDispatcher;
    }
}
