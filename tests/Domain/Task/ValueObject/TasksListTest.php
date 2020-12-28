<?php
declare(strict_types=1);

namespace Tests\Domain\Task\ValueObject;

use App\Domain\Task\Task;
use App\Domain\Task\ValueObject\TasksList;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class TasksListTest extends TestCase
{
    public function prepareTasks()
    {
        return [
            new Task(Uuid::uuid4()->toString(), Uuid::uuid4()->toString(), 'task 1', new DateTimeImmutable('2020-10-10'), true),
            new Task(Uuid::uuid4()->toString(), Uuid::uuid4()->toString(), 'task 2', new DateTimeImmutable('2020-01-10'), false),
            new Task(Uuid::uuid4()->toString(), Uuid::uuid4()->toString(), 'task 3', new DateTimeImmutable(), true),
        ];
    }

    public function testGetters()
    {
        $tasks = $this->prepareTasks();
        $taskList = new TasksList($tasks);

        self::assertEquals($tasks, $taskList->getTasks());
    }

    public function testHasTask()
    {
        $taskList = new TasksList($this->prepareTasks());

        self::assertTrue($taskList->hasTasks());

        $taskList2 = new TasksList([]);

        self::assertFalse($taskList2->hasTasks());
    }

    public function testAddTask()
    {
        $tasks = $this->prepareTasks();
        $taskList = new TasksList($tasks);

        self::assertCount(\count($tasks), $taskList->getTasks());

        $task  = new Task(Uuid::uuid4()->toString(), Uuid::uuid4()->toString(), 'task 4', new DateTimeImmutable(), true);

        $taskList->addTask($task);
        self::assertCount(\count($tasks)+1, $taskList->getTasks());
    }
}
