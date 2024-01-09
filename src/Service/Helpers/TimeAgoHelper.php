<?php

namespace App\Service\Helpers;

use DateTime;
use DateTimeInterface;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class TimeAgoHelper
{

    // public function __construct(
    //     protected TranslatorInterface $translator,
    //     protected ?LoggerInterface $logger = null
    // ){}

    public function __invoke(DateTimeInterface $dateTime): array
    {
        $diff = $dateTime->diff(new DateTime());

        if ($diff->y) {
            return ['type' => 'years', 'value' => $diff->y];
        }

        if ($diff->m) {
            return ['type' => 'months', 'value' => $diff->m];
        }

        if ($diff->d) {
            return ['type' => 'days', 'value' => $diff->d];
        }

        if ($diff->h) {
            return ['type' => 'hours', 'value' => $diff->h];
        }

        if ($diff->i) {
            return ['type' => 'minutes', 'value' => $diff->i];
        }

        return ['type' => 'seconds', 'value' => $diff->s];
    }
}