<?php
declare(strict_types=1);

namespace App\Domain\Task;

use Monolog\DateTimeImmutable;

interface TaskRepository
{
    /**
     * @param string $userId
     * @param DateTimeImmutable $date
     * @return Task[]
     */
    public function findTaskOfUserIdAndDate(string $userId, DateTimeImmutable $date): array;

    /**
     * @param string $id
     * @return Task
     * @throws TaskNotFoundException
     */
    public function findTaskOfId(string $id): Task;
}
