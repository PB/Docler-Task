<?php

declare(strict_types=1);

namespace Tests\Domain\Task\Event;

use App\Domain\Task\Event\TasksListViewed;
use App\Domain\Task\Task;
use App\Domain\Task\ValueObject\TasksList;
use App\Domain\User\User;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

/**
 * Class TasksListViewedTest
 * @package Tests\Domain\Task\Event
 */
class TasksListViewedTest extends TestCase
{
    public function prepareTasks()
    {
        return [
            new Task(
                Uuid::uuid4()->toString(),
                Uuid::uuid4()->toString(),
                'task 1',
                new DateTimeImmutable('2020-10-10'),
                true
            )
            ,
            new Task(
                Uuid::uuid4()->toString(),
                Uuid::uuid4()->toString(),
                'task 2',
                new DateTimeImmutable('2020-01-10'),
                false
            ),
            new Task(
                Uuid::uuid4()->toString(),
                Uuid::uuid4()->toString(),
                'task 3',
                new DateTimeImmutable(),
                true
            ),
        ];
    }

    public function testGetters()
    {
        $tasks = $this->prepareTasks();
        $tasksList = new TasksList($tasks);
        $user = new User(Uuid::uuid4()->toString(), 'test.user');

        $event = new TasksListViewed($tasksList, $user);

        self::assertEquals($tasksList, $event->getTasksList());
        self::assertEquals($tasks, $event->getTasksList()->getTasks());
        self::assertEquals($user, $event->getUser());
    }
}
