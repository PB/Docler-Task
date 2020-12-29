<?php

declare(strict_types=1);

namespace Tests\Domain\User;

use App\Domain\User\User;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function userProvider()
    {
        return [
            [Uuid::uuid4()->toString(), 'bill'],
            [Uuid::uuid4()->toString(), 'steve'],
            [Uuid::uuid4()->toString(), 'mark'],
        ];
    }

    /**
     * @dataProvider userProvider
     * @param $id
     * @param $username
     */
    public function testGetters($id, $username)
    {
        $user = new User($id, $username);

        self::assertEquals($id, $user->getId());
        self::assertEquals($username, $user->getUsername());
    }

    /**
     * @dataProvider userProvider
     * @param $id
     * @param $username
     */
    public function testFromArray($id, $username)
    {
        $user = User::fromArray(['id' => $id, 'username' => $username]);

        self::assertEquals($id, $user->getId());
        self::assertEquals($username, $user->getUsername());
    }

    /**
     * @dataProvider userProvider
     * @param $id
     * @param $username
     */
    public function testJsonSerialize($id, $username)
    {
        $user = new User($id, $username);

        $expectedPayload = json_encode([
            'id' => $id,
            'username' => $username,
        ]);

        self::assertEquals($expectedPayload, json_encode($user));
    }
}
