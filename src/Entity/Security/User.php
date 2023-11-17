<?php

namespace App\Entity\Security;

use App\Entity\EntityIdTrait;
use Lexik\Bundle\JWTAuthenticationBundle\Security\User\JWTUserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

final class User implements JWTUserInterface, PasswordAuthenticatedUserInterface
{
    use EntityIdTrait;

    private ?string $email;
    private ?array $roles;
    private string $username;

    public function __construct($username, ?array $roles, ?string $email)
    {
        $this->username = $username;
        $this->roles = $roles;
        $this->email = $email;
    }

    /**
     * @inheritDoc
     */
    public static function createFromPayload($username, array $payload): User
    {
        return new self(
            $username,
            $payload['roles'] ?? null, // Added by default
            $payload['email'] ?? null  // Custom
        );
    }

    /**
     * @inheritDoc
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * @inheritDoc
     */
    public function getUserIdentifier(): string
    {
        return $this->username;
    }

    public function getPassword(): ?string
    {
        return $this->username;
    }
}