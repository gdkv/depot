<?php

namespace App\Model\Dto;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

readonly class LimitsDto
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Type('array')]
        private ArrayCollection $limits,
    ){}

    public function getLimits(): ArrayCollection
    {
        return $this->limits;
    }


}