<?php

namespace App\Entity\User;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\User\UserTypeReferenceRepository;
use App\Trait\EntityReferenceTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserTypeReferenceRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Get(),
    ]
)]
class UserTypeReference
{
    use EntityReferenceTrait;
}
