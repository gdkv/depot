<?php

namespace App\Security;

use App\Entity\Security\User;
use App\Entity\Sensor\Sensor;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class SensorVoter extends Voter
{
    const VIEW = 'sensor_view';
    const EDIT = 'sensor_edit';
    const DELETE = 'sensor_delete';

    /**
     * @inheritDoc
     */
    protected function supports(string $attribute, mixed $subject): bool
    {
        if (!in_array($attribute, [self::VIEW, self::EDIT, self::DELETE])) {
            return false;
        }

        if (!$subject instanceof Sensor) {
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

        /** @var Sensor $sensor */
        $sensor = $subject;

        return match($attribute) {
            self::VIEW, self::EDIT, self::DELETE => $this->canEdit($sensor, $user),
            default => throw new \LogicException('This code should not be reached!')
        };
    }

    private function canEdit(Sensor $sensor, User $user): bool
    {
        return $user === $sensor->getUser();
    }
}