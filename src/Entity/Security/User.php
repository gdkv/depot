<?php

namespace App\Entity\Security;

use App\Entity\Traits\EntityIdTrait;
use App\Repository\Security\UserRepository;
use OpenApi\Attributes as OA;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[OA\Schema(title: 'Пользователь')]
#[UniqueEntity(fields: 'email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use EntityIdTrait;

    #[ORM\Column(type: Types::STRING, length: 255)]
    #[Assert\Email]
    #[Assert\NotBlank]
    #[OA\Property(title: 'Email', description: 'Email пользователя', type: 'string')]
    private ?string $email;

    #[ORM\Column(type: Types::JSON)]
    #[OA\Property(
        title: 'Роль',
        description: 'Набор ролей пользователя',
        type: 'array',
        items: new OA\Items(type: 'string')
    )]
    private ?array $roles;

    #[ORM\Column(type: Types::STRING)]
    #[Assert\NotBlank]
    #[OA\Property(title: 'Пароль', description: 'Пароль пользователя', type: 'string')]
    private string $password;

    #[ORM\Column(type: Types::STRING)]
    #[OA\Property(title: 'Имя', description: 'Имя пользователя', type: 'string')]
    private string $name;

    public function __construct(
        string $email,
        string $name,
        array $roles
    )
    {
        $this->email = $email;
        $this->name = $name;
        $this->roles = $roles;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }


    public function getName(): string
    {
        return $this->name;
    }


    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }


    public function eraseCredentials(): void
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function getPassword(): ?string
    {
        return $this->password ?? null;
    }

    public function setPassword(string $hashPassword): self
    {
        $this->password = $hashPassword;
        return $this;
    }
}