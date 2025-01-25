<?php

namespace App\Trait;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiProperty;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\UuidV4;

trait EntityIDTrait
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['default:read'])]
    #[ApiFilter(filterClass: SearchFilter::class, properties: ['id' => 'exact'])]
    #[ApiProperty(identifier: false)]
    private ?int $id = null;

    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[Groups(['default:read', 'default:write'])]
    #[ApiFilter(filterClass: SearchFilter::class, properties: ['uuid' => 'exact'])]
    #[ApiProperty(identifier: true)]
    private ?UuidV4 $uuid = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUuid(): ?UuidV4
    {
        return $this->uuid;
    }

    public function setUuid(?UuidV4 $uuid): self
    {
        $this->uuid = $uuid;
        return $this;
    }
}