<?php
declare(strict_types=1);

namespace App\Application\Actions\User\Task;

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
        // will throw error if user not found
        $user = $this->userRepository->findUserOfId($userId);

        $date = new DateTimeImmutable(\date('Y-m-d'));
        $taskList = $this->taskRepository->findTaskOfUserIdAndDate($userId, $date);

        $this->logger->info("Task list of user $userId was viewed.");

        $data = [
            'user' => $user,
            'date' => $date->format('Y-m-d'),
            'tasks' => $taskList->getTasks()
        ];

        return $this->respondWithData($data);
    }
}
