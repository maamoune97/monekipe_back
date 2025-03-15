<?php

namespace App\Core\Entity\Permission;

use ApiPlatform\Metadata\ApiResource;
use App\Common\Trait\EntityDefaultTrait;
use App\Core\Entity\User\UserTypeReference;
use App\Core\Repository\Permission\PermissionGrantRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    normalizationContext: ['groups' => ['default:read', 'userTypePermission:read']],
    denormalizationContext: ['groups' => ['default:write', 'userTypePermission:write']],
)]
#[ORM\Entity(repositoryClass: PermissionGrantRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_USER_TYPE_PERMISSION', fields: ['userType', 'permission'])]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: false)]
class PermissionGrant
{
    use EntityDefaultTrait;

    #[ORM\ManyToOne(inversedBy: 'permissionGrants')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['userTypePermission:read', 'userTypePermission:write'])]
    private ?UserTypeReference $userType = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['userTypePermission:read', 'userTypePermission:write', 'user:read', 'user:write'])]
    private ?Permission $permission = null;

    #[ORM\Column(type: 'boolean', nullable: false, options: ['default' => false])]
    #[Groups(['userTypePermission:read', 'userTypePermission:write', 'user:read', 'user:write'])]
    private ?bool $isGranted = null;


    public function getUserType(): ?UserTypeReference
    {
        return $this->userType;
    }

    public function setUserType(?UserTypeReference $userType): static
    {
        $this->userType = $userType;

        return $this;
    }

    public function getPermission(): ?Permission
    {
        return $this->permission;
    }

    public function setPermission(?Permission $permission): static
    {
        $this->permission = $permission;

        return $this;
    }

    public function getIsGranted(): ?bool
    {
        return $this->isGranted;
    }

    public function setIsGranted(?bool $isGranted): static
    {
        $this->isGranted = $isGranted;

        return $this;
    }
}
