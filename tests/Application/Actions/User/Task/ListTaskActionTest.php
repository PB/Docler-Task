<?php

declare(strict_types=1);

namespace Tests\Application\Actions\User\Task;

use App\Application\Actions\ActionPayload;
use App\Domain\Task\Task;
use App\Domain\Task\TaskRepository;
use App\Domain\Task\ValueObject\TasksList;
use App\Domain\User\UserRepository;
use App\Domain\User\User;
use DI\Container;
use DateTimeImmutable;
use Prophecy\PhpUnit\ProphecyTrait;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class ListTaskActionTest extends TestCase
{
    use ProphecyTrait;

    public function testAction()
    {
        $app = $this->getAppInstance();

        /** @var Container $container */
        $container = $app->getContainer();

        $userId = Uuid::uuid4()->toString();
        $user = new User($userId, 'test.user');

        $userRepositoryProphecy = $this->prophesize(UserRepository::class);
        $userRepositoryProphecy
            ->findUserOfId($userId)
            ->willReturn($user)
            ->shouldBeCalledOnce();

        $container->set(UserRepository::class, $userRepositoryProphecy->reveal());

        $tasks = [
            new Task(Uuid::uuid4()->toString(), $user->getId(), 'test task one', new DateTimeImmutable(), true),
            new Task(Uuid::uuid4()->toString(), $user->getId(), 'test task two', new DateTimeImmutable(), false),
        ];
        $date = new DateTimeImmutable(\date('Y-m-d'));
        $taskList = new TasksList($tasks);

        $taskRepositoryProphecy = $this->prophesize(TaskRepository::class);
        $taskRepositoryProphecy
            ->findTaskOfUserIdAndDate($userId, $date)
            ->willReturn($taskList)
            ->shouldBeCalledOnce();

        $container->set(TaskRepository::class, $taskRepositoryProphecy->reveal());


        $request = $this->createRequest('GET', '/users/' . $userId . '/tasks');
        $response = $app->handle($request);

        $payload = (string)$response->getBody();

        $data = [
            'user' => $user,
            'date' => $date->format('Y-m-d'),
            'tasks' => $taskList->getTasks()
        ];

        $expectedPayload = new ActionPayload(200, $data);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        self::assertEquals($serializedPayload, $payload);
    }
}
