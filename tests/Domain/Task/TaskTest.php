<?php
declare(strict_types=1);

namespace Tests\Domain\Task;

use App\Domain\Task\Task;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class TaskTest extends TestCase
{
    public function taskProvider()
    {
        return [
            [Uuid::uuid4()->toString(), Uuid::uuid4()->toString(), 'task 1', new DateTimeImmutable('2020-10-10'), true],
            [Uuid::uuid4()->toString(), Uuid::uuid4()->toString(), 'task 2', new DateTimeImmutable('2020-01-10'), false],
            [Uuid::uuid4()->toString(), Uuid::uuid4()->toString(), 'task 3', new DateTimeImmutable(), true],
        ];
    }

    /**
     * @dataProvider taskProvider
     * @param $id
     * @param $userId
     * @param $name
     * @param $date
     * @param $done
     */
    public function testGetters($id, $userId, $name, $date, $done)
    {
        $task = new Task($id, $userId, $name, $date, $done);

        self::assertEquals($id, $task->getId());
        self::assertEquals($userId, $task->getUserId());
        self::assertEquals($name, $task->getName());
        self::assertEquals($date, $task->getDate());
        self::assertEquals($done, $task->isDone());
    }

    /**
     * @dataProvider taskProvider
     * @param $id
     * @param $userId
     * @param $name
     * @param $date
     * @param $done
     */
    public function testJsonSerialize($id, $userId, $name, $date, $done)
    {
        $task = new Task($id, $userId, $name, $date, $done);

        $expectedPayload = json_encode([
            'id' => $id,
            'name' => $name,
            'is_done' => $done,
        ]);

        self::assertEquals($expectedPayload, json_encode($task));
    }

    /**
     * @dataProvider taskProvider
     * @param $id
     * @param $userId
     * @param $name
     * @param $date
     * @param $done
     */
    public function testMarkAsDone($id, $userId, $name, $date, $done)
    {
        $task = new Task($id, $userId, $name, $date, $done);
        $task->markTaskAsDone();

        self::assertTrue($task->isDone());
    }
}
