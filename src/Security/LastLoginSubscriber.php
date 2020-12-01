<?php

namespace App\Security;

use App\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;

class LastLoginSubscriber implements EventSubscriberInterface
{
    public function onLoginSuccess(LoginSuccessEvent $event)
    {
        $user = $event->getUser();

        if (!$user instanceof User) {
            throw new \Exception('what the heck?');
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            LoginSuccessEvent::class => 'onLoginSuccess',
        ];
    }
}
