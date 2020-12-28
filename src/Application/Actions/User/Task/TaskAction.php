<?php
declare(strict_types=1);

namespace App\Application\Actions\User\Task;

use App\Application\Actions\Action;
use App\Domain\Task\TaskRepository;
use App\Domain\User\UserRepository;
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
     * @param LoggerInterface $logger
     * @param UserRepository $userRepository
     * @param TaskRepository $taskRepository
     */
    public function __construct(LoggerInterface $logger, UserRepository $userRepository, TaskRepository $taskRepository)
    {
        parent::__construct($logger);
        $this->userRepository = $userRepository;
        $this->taskRepository = $taskRepository;
    }
}
