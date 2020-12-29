<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Persistence\User;

use App\Domain\Task\TaskNotFoundException;
use App\Domain\Task\TaskRepository;
use App\Domain\Task\ValueObject\TasksList;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class PostgresqlTaskRepositoryTest extends TestCase
{

    public function testFindTaskOfIdThrowsNotFoundException()
    {
        $taskRepository = $this->getAppInstance()->getContainer()->get(TaskRepository::class);
        $this->expectException(TaskNotFoundException::class);
        $taskRepository->findTaskOfId(Uuid::uuid4()->toString());
    }

    public function testFindTaskOfId()
    {
        $taskRepository = $this->getAppInstance()->getContainer()->get(TaskRepository::class);
        $task =  $taskRepository->findTaskOfId('fb538c52-648a-42ae-bfb6-ef03a19828d1');
        self::assertEquals('fb538c52-648a-42ae-bfb6-ef03a19828d1', $task->getId());
        self::assertEquals('8cdf1af4-a1ce-43f1-a082-a183d71fd685', $task->getUserId());
        self::assertEquals('Task One', $task->getName());
        self::assertEquals(new DateTimeImmutable(date('Y-m-d')), $task->getDate());
        self::assertFalse($task->isDone());
    }

    public function testFindTaskOfUserIdAndDateNotFound()
    {
        $taskRepository = $this->getAppInstance()->getContainer()->get(TaskRepository::class);
        $tasksList =  $taskRepository->findTaskOfUserIdAndDate(
            '8cdf1af4-a1ce-43f1-a082-a183d71fd685',
            new \DateTimeImmutable('2018-10-10')
        );
        self::assertFalse($tasksList->hasTasks());
    }

    public function testFindTaskOfUserIdAndDate()
    {
        $taskRepository = $this->getAppInstance()->getContainer()->get(TaskRepository::class);
        $tasksList =  $taskRepository->findTaskOfUserIdAndDate(
            '8cdf1af4-a1ce-43f1-a082-a183d71fd685',
            new \DateTimeImmutable()
        );
        self::assertInstanceOf(TasksList::class, $tasksList);
        self::assertTrue($tasksList->hasTasks());
        self::assertCount(10, $tasksList->getTasks());
    }
}
