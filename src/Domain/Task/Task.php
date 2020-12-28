<?php
declare(strict_types=1);

namespace App\Domain\Task;

use DateTimeImmutable;

/**
 * Class Task
 * @package App\Domain\Task
 */
class Task implements \JsonSerializable
{
    private string $id;

    private string $userId;

    private string $name;

    private DateTimeImmutable $date;

    private bool $done;

    /**
     * Task constructor.
     * @param string $id
     * @param string $userId
     * @param string $name
     * @param DateTimeImmutable $date
     * @param bool $done
     */
    public function __construct(string $id, string $userId, string $name, DateTimeImmutable $date, bool $done)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->name = $name;
        $this->date = $date;
        $this->done = $done;
    }

    /**
     * @param array $data
     * @return Task
     */
    public static function fromArray(array $data): Task
    {
        return new self(
            $data['id'],
            $data['user_id'],
            $data['name'],
            new DateTimeImmutable($data['date']),
            $data['done']);
    }

    /**
     * Mark task as done
     */
    public function markTaskAsDone(): void
    {
        $this->done = true;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    /**
     * @return bool
     */
    public function isDone(): bool
    {
        return $this->done;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'is_done' => $this->done
        ];
    }
}
