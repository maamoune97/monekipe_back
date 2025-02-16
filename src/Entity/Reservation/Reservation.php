<?php

namespace App\Entity\Reservation;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Entity\Event\Event;
use App\Entity\User\User;
use App\Entity\User\UserGuest;
use App\Repository\Reservation\ReservationRepository;
use App\State\Reservation\ReservationProcessor;
use App\Trait\EntityDefaultTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Get(),
        new Post(
            processor: ReservationProcessor::class
        ),
        new Patch(),
    ],
    normalizationContext: ['groups' => ['reservation:read', 'default:read']],
    denormalizationContext: ['groups' => ['reservation:write', 'default:write']],
)]
class Reservation
{
    use EntityDefaultTrait;

    #[Groups(['reservation:read', 'reservation:write'])]
    #[ORM\ManyToOne(inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Event $event = null;

    #[Groups(['reservation:read', 'reservation:write'])]
    #[ORM\ManyToOne(inversedBy: 'reservations')]
    private ?User $customer = null;

    #[Groups(['reservation:read', 'reservation:write'])]
    #[ORM\ManyToOne(cascade: ['persist'], inversedBy: 'reservations')]
    private ?UserGuest $guestCustomer = null;

    #[ORM\Column]
    private ?bool $isUsed = false;

    #[Assert\Callback()]
    public function customerRequired(ExecutionContextInterface $context): void
    {
        if (!$this->customer && !$this->guestCustomer) {
            $context->buildViolation('Either customer or guestCustomer is required')
                ->atPath('customer')
                ->addViolation();
        }
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): static
    {
        $this->event = $event;

        return $this;
    }

    public function getCustomer(): ?User
    {
        return $this->customer;
    }

    public function setCustomer(?User $customer): static
    {
        $this->customer = $customer;

        return $this;
    }

    public function getGuestCustomer(): ?UserGuest
    {
        return $this->guestCustomer;
    }

    public function setGuestCustomer(?UserGuest $guestCustomer): static
    {
        $this->guestCustomer = $guestCustomer;

        return $this;
    }

    public function isUsed(): ?bool
    {
        return $this->isUsed;
    }

    public function setIsUsed(bool $isUsed): static
    {
        $this->isUsed = $isUsed;

        return $this;
    }

}
