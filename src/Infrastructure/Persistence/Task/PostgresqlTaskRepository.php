<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Task;

use App\Domain\Task\Task;
use App\Domain\Task\TaskNotFoundException;
use App\Domain\Task\TaskRepository;
use App\Domain\Task\ValueObject\TasksList;
use App\Infrastructure\Persistence\Postgresql\Connection;
use DateTimeImmutable;
use PDO;

class PostgresqlTaskRepository implements TaskRepository
{
    /** @var Connection */
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * {@inheritdoc}
     */
    public function findTaskOfId(string $id): Task
    {
        $sql = 'SELECT * FROM tasks WHERE id = :id';
        $stmt = $this->connection->execute($sql, [
            'id' => $id,
        ]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            throw new TaskNotFoundException();
        }

        return Task::fromArray($result);
    }

    /**
     * {@inheritdoc}
     */
    public function findTaskOfUserIdAndDate(string $userId, DateTimeImmutable $date): TasksList
    {
        $sql = 'SELECT * FROM tasks WHERE user_id = :user_id AND date = :date ORDER BY done DESC';
        $stmt = $this->connection->execute($sql, [
            'user_id' => $userId,
            'date' => $date->format('Y-m-d')
        ]);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $tasks = new TasksList();
        if (is_array($result)) {
            foreach ($result as $task) {
                $tasks->addTask(Task::fromArray($task));
            }
        }

        return $tasks;
    }
}
