<?php

namespace App\Core\EventListener\Permission;

use App\Core\Entity\Permission\Permission;
use App\Core\Service\Permission\PermissionService;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;

#[AsEntityListener(event: Events::prePersist, method: 'prePersist', entity: Permission::class)]
readonly class PrePersistPermissionListener
{
    public function __construct(private PermissionService $permissionService)
    {
    }

    /**
     * This method is triggered before a Permission entity is persisted.
     * It ensures that a UserTypePermission entity is created for each UserTypeReference
     * if it does not already exist.
     *
     * @param Permission $permission The Permission entity being persisted.
     */
    public function prePersist(Permission $permission): void
    {
        $this->permissionService->initPermissionGrantsByPermission($permission);
    }
}