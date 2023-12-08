<?php

namespace App\Security;

use App\Entity\Security\User;
use App\Entity\Sensor\Sensor;
use App\Entity\Sensor\Zone;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class ZoneVoter extends Voter
{
    const VIEW = 'zone_view';
    const EDIT = 'zone_edit';
    const DELETE = 'zone_delete';

    /**
     * @inheritDoc
     */
    protected function supports(string $attribute, mixed $subject): bool
    {
        if (!in_array($attribute, [self::VIEW, self::EDIT, self::DELETE])) {
            return false;
        }

        if (!$subject instanceof Zone) {
            return false;
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
       $user = $token->getUser();

        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }

        /** @var Zone $sensor */
        $zone = $subject;

        return match($attribute) {
            self::VIEW, self::EDIT, self::DELETE => $this->canEdit($zone, $user),
            default => throw new \LogicException('This code should not be reached!')
        };
    }

    private function canEdit(Zone $zone, User $user): bool
    {
        return $user === $zone->getUser();
    }
}