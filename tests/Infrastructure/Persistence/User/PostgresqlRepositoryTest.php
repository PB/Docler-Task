<?php
declare(strict_types=1);

namespace Tests\Infrastructure\Persistence\User;

use App\Domain\User\UserNotFoundException;
use App\Infrastructure\Persistence\Postgresql\Connection;
use App\Infrastructure\Persistence\User\PostgresqlUserRepository;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class PostgresqlRepositoryTest extends TestCase
{
    private function prepareRepository()
    {
        $connection = $this->getAppInstance()->getContainer()->get(Connection::class);
        return new PostgresqlUserRepository($connection);
    }

    public function testFindUserOfIdThrowsNotFoundException()
    {
        $userRepository = $this->prepareRepository();
        $this->expectException(UserNotFoundException::class);
        $userRepository->findUserOfId(Uuid::uuid4()->toString());
    }

    public function testFindUserOfId()
    {
        $userRepository = $this->prepareRepository();
        $user =  $userRepository->findUserOfId('8cdf1af4-a1ce-43f1-a082-a183d71fd685');
        self::assertEquals('8cdf1af4-a1ce-43f1-a082-a183d71fd685', $user->getId());
        self::assertEquals('user.one', $user->getUsername());
    }
}
