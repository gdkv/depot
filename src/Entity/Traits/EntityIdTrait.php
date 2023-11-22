<?php
namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use OpenApi\Attributes as OA;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Component\Uid\UuidV7;
use Symfony\Component\Validator\Constraints as Assert;

trait EntityIdTrait {

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[OA\Property(description: 'ID')]
    #[Assert\NotBlank]
    #[Assert\Uuid]
    private ?UuidV7 $id;

    public function getId(): ?UuidV7
    {
        return $this->id;
    }

}