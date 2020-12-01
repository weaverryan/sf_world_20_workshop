<?php

namespace App\Security;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class LastLoginSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
    }
}
