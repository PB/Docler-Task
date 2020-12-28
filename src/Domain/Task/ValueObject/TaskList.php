<?php
declare(strict_types=1);

namespace App\Domain\Task\ValueObject;

use App\Domain\Task\Task;

/**
 * Class Task
 * @package App\Domain\Task
 */
class TaskList
{
    /**
     * @var Task[]
     */
    private array $tasks;

    /**
     * TaskList constructor.
     * @param Task[] $tasks
     */
    public function __construct(array $tasks)
    {
        $this->tasks = $tasks;
    }

    /**
     * @return Task[]
     */
    public function getTasks(): array
    {
        return $this->tasks;
    }
}
