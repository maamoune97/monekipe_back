<?php

namespace App\Core\Entity\Permission;

use ApiPlatform\Metadata\ApiResource;
use App\Common\Trait\EntityDefaultTrait;
use App\Core\Repository\Permission\PermissionRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    normalizationContext: ['groups' => ['default:read', 'permission:read']],
    denormalizationContext: ['groups' => ['default:write', 'permission:write']],
)]
#[ORM\Entity(repositoryClass: PermissionRepository::class)]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: false)]
class Permission
{
    use EntityDefaultTrait;

    #[ORM\Column(length: 100)]
    #[Groups(['permission:read', 'permission:write', 'user:read', 'user:write'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['permission:read', 'permission:write', 'user:read', 'user:write'])]
    private ?string $description = null;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }
}
