<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Component\Uid\UuidV7;
use OpenApi\Attributes as OA;

trait EntityIdTrait {

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[OA\Property(description: 'ID')]
    private ?UuidV7 $id;

    public function getId(): ?UuidV7
    {
        return $this->id;
    }

}