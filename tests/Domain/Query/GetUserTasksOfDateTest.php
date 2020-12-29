<?php

declare(strict_types=1);

namespace Tests\Domain\Query;

use App\Domain\Query\GetUserTasksOfDate;
use App\Domain\Task\Task;
use App\Domain\Task\TaskRepository;
use App\Domain\Task\ValueObject\TasksList;
use App\Domain\User\User;
use DateTimeImmutable;
use DI\Container;
use Prophecy\PhpUnit\ProphecyTrait;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class GetUserTasksOfDateTest extends TestCase
{
    use ProphecyTrait;

    public function testExecute()
    {
        $app = $this->getAppInstance();

        /** @var Container $container */
        $container = $app->getContainer();

        $user = new User(Uuid::uuid4()->toString(), 'test.user');
        $tasks = [
            new Task(Uuid::uuid4()->toString(), $user->getId(), 'test task one', new DateTimeImmutable(), true),
            new Task(Uuid::uuid4()->toString(), $user->getId(), 'test task two', new DateTimeImmutable(), false),
        ];

        $tasksList = new TasksList($tasks);
        $date = new DateTimeImmutable(\date('Y-m-d'));

        $taskRepositoryProphecy = $this->prophesize(TaskRepository::class);
        $taskRepositoryProphecy
            ->findTaskOfUserIdAndDate($user->getId(), $date)
            ->willReturn($tasksList)
            ->shouldBeCalledOnce();

        $container->set(TaskRepository::class, $taskRepositoryProphecy->reveal());

        $query = new GetUserTasksOfDate($user, $container->get(TaskRepository::class));
        $result = $query->execute();

        self::assertEquals($tasksList, $result);
    }
}
