<?php

namespace App\Common\Trait;

use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

trait  EntityReferenceTrait
{
    use EntityDefaultTrait;

    #[Groups(['default:read', 'default:write'])]
    #[ORM\Column(type: 'string', length: 64)]
    #[ApiFilter(filterClass: SearchFilter::class, strategy: "start")]
    private string $label;

    #[Groups(['default:read', 'default:write'])]
    #[ORM\Column(type: 'string', length: 64, nullable: true)]
    #[ApiFilter(filterClass: SearchFilter::class, strategy: "start")]
    private ?string $value = null;

    #[Groups(['default:read', 'default:write'])]
    #[ORM\Column(type: 'integer')]
    #[ApiFilter(filterClass: OrderFilter::class)]
    private int $rank = 0;

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;
        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value): self
    {
        $this->value = $value;
        return $this;
    }

    public function getRank(): int
    {
        return $this->rank;
    }

    public function setRank(int $rank): self
    {
        $this->rank = $rank;
        return $this;
    }
}