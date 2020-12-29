<?php
declare(strict_types=1);

namespace App\Application\Actions\User\Task;

use App\Domain\Query\GetUserTasksOfDate;
use App\Domain\Task\Event\TasksListViewed;
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

        $query = new GetUserTasksOfDate($user, $this->taskRepository);
        $tasksList = $query->execute();

        $event = new TasksListViewed($tasksList, $user);
        $this->eventDispatcher->dispatch($event);

        $data = [
            'user' => $user,
            'date' => date('Y-m-d'),
            'tasks' => $tasksList->getTasks()
        ];

        return $this->respondWithData($data);
    }
}
