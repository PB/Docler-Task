<?php

declare(strict_types=1);

namespace App\Domain\Task\ValueObject;

use App\Domain\Task\Task;

/**
 * Class Task
 * @package App\Domain\Task
 */
class TasksList
{
    /**
     * @var Task[]
     */
    private array $tasks;

    /**
     * TasksList constructor.
     * @param Task[] $tasks
     */
    public function __construct(array $tasks = [])
    {
        $this->tasks = $tasks;
    }

    public function addTask(Task $task): void
    {
        $this->tasks[] = $task;
    }

    public function hasTasks(): bool
    {
        return !empty($this->tasks);
    }

    /**
     * @return Task[]
     */
    public function getTasks(): array
    {
        return $this->tasks;
    }
}
