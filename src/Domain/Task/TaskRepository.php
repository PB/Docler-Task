<?php
declare(strict_types=1);

namespace App\Domain\Task;

use App\Domain\Task\ValueObject\TasksList;
use DateTimeImmutable;

interface TaskRepository
{
    /**
     * @param string $userId
     * @param DateTimeImmutable $date
     * @return TasksList
     */
    public function findTaskOfUserIdAndDate(string $userId, DateTimeImmutable $date): TasksList;

    /**
     * @param string $id
     * @return Task
     * @throws TaskNotFoundException
     */
    public function findTaskOfId(string $id): Task;
}
