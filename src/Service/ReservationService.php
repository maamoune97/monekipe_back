<?php

namespace App\Service;

use App\Entity\Reservation\Reservation;
use App\Repository\Event\EventRepository;
use App\Repository\Reservation\ReservationRepository;
use Doctrine\DBAL\LockMode;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class ReservationService
{
    public function __construct(
        private ReservationRepository $reservationRepository,
        private EntityManagerInterface $entityManager,
    )
    {
    }

    public function create(Reservation $reservation)
    {
        $this->entityManager->beginTransaction();
        try {
            $existingReservations = $this->reservationRepository->count(['event' => $reservation->getEvent()]);

            if ($existingReservations >= $reservation->getEvent()->getCapacity()) {

            }
        }
        catch (\Exception $e) {

        }



    }

}