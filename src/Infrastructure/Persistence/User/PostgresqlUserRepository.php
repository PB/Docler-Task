<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\User;

use App\Domain\User\User;
use App\Domain\User\UserNotFoundException;
use App\Domain\User\UserRepository;
use App\Infrastructure\Persistence\Postgresql\Connection;
use PDO;

/**
 * Class PostgresqlUserRepository
 * @package App\Infrastructure\Persistence\User
 */
class PostgresqlUserRepository implements UserRepository
{
    /** @var Connection */
    private Connection $connection;

    /**
     * PostgresqlUserRepository constructor.
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * {@inheritdoc}
     */
    public function findUserOfId(string $id): User
    {
        $sql = 'SELECT * FROM users WHERE id = :id';
        $stmt = $this->connection->execute($sql, [
            'id' => $id,
        ]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            throw new UserNotFoundException();
        }

        return User::fromArray($result);
    }
}
