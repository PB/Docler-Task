<?php

declare(strict_types=1);

namespace App\Domain\Query;

use App\Domain\Task\TaskRepository;
use App\Domain\Task\ValueObject\TasksList;
use App\Domain\User\User;
use DateTimeImmutable;

/**
 * Class GetUserTasksOfDate
 * @package App\Domain\Query
 */
class GetUserTasksOfDate implements Query
{
    /**
     * @var User
     */
    private User $user;
    /**
     * @var TaskRepository
     */
    private TaskRepository $taskRepository;

    /**
     * GetUserTasksOfDate constructor.
     * @param User $user
     * @param TaskRepository $taskRepository
     */
    public function __construct(User $user, TaskRepository $taskRepository)
    {
        $this->user = $user;
        $this->taskRepository = $taskRepository;
    }

    /**
     * @return TasksList
     * @throws \Exception
     */
    public function execute(): TasksList
    {
        $date = new DateTimeImmutable(\date('Y-m-d'));

        return $this->taskRepository->findTaskOfUserIdAndDate($this->user->getId(), $date);
    }
}
