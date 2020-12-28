<?php

namespace App\Infrastructure\Persistence\Postgresql;

use PDO;
use PDOStatement;

class Connection
{
    /** @var ?PDO */
    private static ?PDO $connection = null;

    /**
     * Connection constructor.
     * @param string $host
     * @param string $port
     * @param string $name
     * @param string $user
     * @param string $pass
     */
    public function __construct(string $host, string $port, string $name, string $user, string $pass)
    {
        if (self::$connection === null) {
            $conStr = sprintf(
                "pgsql:host=%s;port=%d;dbname=%s;user=%s;password=%s",
                $host,
                $port,
                $name,
                $user,
                $pass
            );

            self::$connection = new PDO($conStr);
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
    }

    /**
     * @param string $sql
     * @param array $params
     * @return PDOStatement
     */
    public function execute(string $sql, array $params): PDOStatement
    {
        $stmt = self::$connection->prepare($sql);
        $stmt->execute($params);

        return $stmt;
    }
}
