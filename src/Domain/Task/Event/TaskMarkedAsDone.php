<?php

declare(strict_types=1);

namespace App\Domain\Task\Event;

use App\Domain\Task\Task;

/**
 * Class TaskMarkedAsDone
 * @package App\Domain\Task\Event
 */
class TaskMarkedAsDone
{
    /**
     * @var Task
     */
    private Task $task;

    /**
     * TaskMarkedAsDone constructor.
     * @param Task $task
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * @return Task
     */
    public function getTask(): Task
    {
        return $this->task;
    }
}
