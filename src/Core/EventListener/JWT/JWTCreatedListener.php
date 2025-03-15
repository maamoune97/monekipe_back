<?php

namespace App\Core\EventListener\JWT;


use App\Core\Entity\User\User;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;


class JWTCreatedListener
{

    public function onJWTCreated(JWTCreatedEvent $event): void
    {
        $user = $event->getUser();
        if (!$user instanceof User) {
            return;
        }
        $event->setData([
            'username' => $user->getEmail(),
            'uerType' => $user->getUserTypeReference()->getValue(),
        ]);
    }

}
