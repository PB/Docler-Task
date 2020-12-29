<?php

declare(strict_types=1);

namespace App\Domain\Task\Event;

use App\Domain\Task\ValueObject\TasksList;
use App\Domain\User\User;

/**
 * Class TasksListViewed
 * @package App\Domain\Task\Event
 */
class TasksListViewed
{
    /** @var TasksList */
    private TasksList $tasksList;
    /** @var User */
    private User $user;

    /**
     * TasksListViewed constructor.
     * @param TasksList $tasksList
     * @param User $user
     */
    public function __construct(TasksList $tasksList, User $user)
    {
        $this->tasksList = $tasksList;
        $this->user = $user;
    }

    /**
     * @return TasksList
     */
    public function getTasksList(): TasksList
    {
        return $this->tasksList;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }
}
