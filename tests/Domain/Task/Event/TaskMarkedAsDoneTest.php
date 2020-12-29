<?php

declare(strict_types=1);

namespace Tests\Domain\Task\Event;

use App\Domain\Task\Event\TaskMarkedAsDone;
use App\Domain\Task\Task;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class TaskMarkedAsDoneTest extends TestCase
{
    public function testGetters()
    {
        $task = new Task(
            Uuid::uuid4()->toString(),
            Uuid::uuid4()->toString(),
            'task 1',
            new DateTimeImmutable('2020-10-10'),
            true
        );

        $event = new TaskMarkedAsDone($task);

        self::assertEquals($task, $event->getTask());
        self::assertEquals($task->isDone(), $event->getTask()->isDone());
    }
}
