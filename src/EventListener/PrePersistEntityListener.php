<?php

namespace App\EventListener;

use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\Uid\UuidV4;

class PrePersistEntityListener
{
    public function prePersist(PrePersistEventArgs $args): void
    {
        $entity = $args->getObject();
        if (method_exists($entity, 'getUuid') && $entity->getUuid() === null) {
            $entity->setUuid(new UuidV4());
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            Events::prePersist,
        ];
    }
}
