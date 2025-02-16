<?php

namespace App\Entity\User;

use ApiPlatform\Metadata\NotExposed;
use App\Entity\Reservation\Reservation;
use App\Repository\User\UserGuestRepository;
use App\Trait\EntityDefaultTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: UserGuestRepository::class)]
#[NotExposed(
    normalizationContext: ['groups' => ['default:read']],
    denormalizationContext: ['groups' => ['default:write']],
)]
class UserGuest
{
    use EntityDefaultTrait;

    #[Groups(['reservation:read', 'reservation:write'])]
    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[Groups(['reservation:read', 'reservation:write'])]
    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[Groups(['reservation:read', 'reservation:write'])]
    #[ORM\Column(length: 255)]
    private ?string $email = null;

    /**
     * @var Collection<int, Reservation>
     */
    #[ORM\OneToMany(targetEntity: Reservation::class, mappedBy: 'guestCustomer')]
    private Collection $reservations;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): static
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setGuestCustomer($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): static
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getGuestCustomer() === $this) {
                $reservation->setGuestCustomer(null);
            }
        }

        return $this;
    }
}
