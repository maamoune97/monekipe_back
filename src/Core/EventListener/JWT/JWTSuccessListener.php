<?php

namespace App\Core\EventListener\JWT;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

readonly class JWTSuccessListener
{
    public function __construct(private NormalizerInterface $normalizer)
    {
    }

    /**
     * @throws ExceptionInterface
     */
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event): void
    {
        $event->setData([
            'token' => $event->getData()['token'],
            'user' => $this->normalizer->normalize($event->getUser(), null, ['groups' => ['user:read', 'default:read']]),
        ]);
    }

}




