<?php

namespace App\Core\Repository\Permission;

use App\Core\Entity\Permission\PermissionGrant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PermissionGrant>
 */
class PermissionGrantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PermissionGrant::class);
    }
}
