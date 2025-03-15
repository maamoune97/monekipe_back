<?php

namespace App\Core\Entity\User;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Common\Trait\EntityReferenceTrait;
use App\Core\Entity\Permission\PermissionGrant;
use App\Core\Repository\User\UserTypeReferenceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: UserTypeReferenceRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Get(),
    ],
    normalizationContext: ['groups' => ['default:read', 'userType:read']],
    denormalizationContext: ['groups' => ['default:write', 'userType:write']],
)]
class UserTypeReference
{
    use EntityReferenceTrait;


    /**
     * @var Collection<int, PermissionGrant>
     */
    #[ORM\OneToMany(targetEntity: PermissionGrant::class, mappedBy: 'userType')]
    #[Groups(['userType:read', 'userType:write', 'user:read'])]
    private Collection $permissionGrants;

    public function __construct()
    {
        $this->permissionGrants = new ArrayCollection();
    }

    /**
     * @return Collection<int, PermissionGrant>
     */
    public function getPermissionGrants(): Collection
    {
        return $this->permissionGrants;
    }

    public function addPermissionGrant(PermissionGrant $permissionGrant): static
    {
        if (!$this->permissionGrants->contains($permissionGrant)) {
            $this->permissionGrants->add($permissionGrant);
            $permissionGrant->setUserType($this);
        }

        return $this;
    }

    public function removePermissionGrant(PermissionGrant $permissionGrant): static
    {
        if ($this->permissionGrants->removeElement($permissionGrant)) {
            // set the owning side to null (unless already changed)
            if ($permissionGrant->getUserType() === $this) {
                $permissionGrant->setUserType(null);
            }
        }

        return $this;
    }
}
