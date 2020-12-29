<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Persistence\User;

use App\Domain\User\UserNotFoundException;
use App\Domain\User\UserRepository;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

/**
 * Class PostgresqlUserRepositoryTest
 * @package Tests\Infrastructure\Persistence\User
 */
class PostgresqlUserRepositoryTest extends TestCase
{
    /**
     * @throws UserNotFoundException
     */
    public function testFindUserOfIdThrowsNotFoundException()
    {
        $userRepository = $this->getAppInstance()->getContainer()->get(UserRepository::class);
        $this->expectException(UserNotFoundException::class);
        $userRepository->findUserOfId(Uuid::uuid4()->toString());
    }

    /**
     * @throws UserNotFoundException
     */
    public function testFindUserOfId()
    {
        $userRepository = $this->getAppInstance()->getContainer()->get(UserRepository::class);
        $user =  $userRepository->findUserOfId('8cdf1af4-a1ce-43f1-a082-a183d71fd685');
        self::assertEquals('8cdf1af4-a1ce-43f1-a082-a183d71fd685', $user->getId());
        self::assertEquals('user.one', $user->getUsername());
    }
}
