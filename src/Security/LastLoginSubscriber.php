<?php

namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Event\CheckPassportEvent;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;

class LastLoginSubscriber implements EventSubscriberInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function onLoginSuccess(LoginSuccessEvent $event)
    {
        $user = $event->getUser();

        if (!$user instanceof User) {
            throw new \Exception('what the heck?');
        }

        $user->setLastLoginAt(new \DateTimeImmutable('now'));
        $this->entityManager->flush();
    }

    public function onCheckPassport(CheckPassportEvent $event)
    {
        $userBadge = $event->getPassport()->getBadge(UserBadge::class);

        if (!$userBadge instanceof UserBadge) {
            throw new \Exception('What the heck?');
        }


    }

    public static function getSubscribedEvents()
    {
        return [
            LoginSuccessEvent::class => 'onLoginSuccess',
            CheckPassportEvent::class => 'onCheckPassport',
        ];
    }
}
