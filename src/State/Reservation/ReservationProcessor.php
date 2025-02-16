<?php

namespace App\State\Reservation;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;

class ReservationProcessor implements ProcessorInterface
{
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        dd($data);
        // Handle the state
    }
}
