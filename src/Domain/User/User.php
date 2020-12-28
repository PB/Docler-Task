<?php
declare(strict_types=1);

namespace App\Domain\User;

/**
 * Class User
 * @package App\Domain\User
 */
class User implements \JsonSerializable
{
    /**
     * @var string
     */
    private string $id;

    /**
     * @var string
     */
    private string $username;

    /**
     * @param string $id
     * @param string $username
     */
    public function __construct(string $id, string $username)
    {
        $this->id = $id;
        $this->username = strtolower($username);
    }

    /**
     * @param array $data
     * @return User
     */
    public static function fromArray(array $data): User
    {
        return new self($data['id'], $data['username']);
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
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
        ];
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
        ];    }
}
