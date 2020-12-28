<?php
declare(strict_types=1);

namespace App\Application\Actions\User\Task;

use App\Domain\Task\Task;
use App\Domain\Task\ValueObject\TaskList;
use DateTimeImmutable;
use Psr\Http\Message\ResponseInterface as Response;
use Ramsey\Uuid\Uuid;
use Slim\Exception\HttpBadRequestException;

class ListTasksAction extends TaskAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $userId = (string)$this->resolveArg('user_id');
        if (!Uuid::isValid($userId)) {
            throw new HttpBadRequestException($this->request);
        }
        $user = $this->userRepository->findUserOfId($userId);

        $tasks = [
            new Task(Uuid::uuid4()->toString(), Uuid::uuid4()->toString(), 'task 1', new DateTimeImmutable(), true),
            new Task(Uuid::uuid4()->toString(), Uuid::uuid4()->toString(), 'task 2', new DateTimeImmutable(), false),
            new Task(Uuid::uuid4()->toString(), Uuid::uuid4()->toString(), 'task 3', new DateTimeImmutable(), true),
        ];
        $tasksList = new TaskList($tasks);

        $this->logger->info("Task list was viewed.");

        return $this->respondWithData($tasks);
    }
}
