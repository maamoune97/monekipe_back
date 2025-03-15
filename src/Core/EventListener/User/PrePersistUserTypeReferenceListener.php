<?php

namespace App\Core\EventListener\User;

use App\Core\Entity\User\UserTypeReference;
use App\Core\Service\Permission\PermissionService;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;

#[AsEntityListener(event: Events::prePersist, method: 'prePersist', entity: UserTypeReference::class)]
readonly class PrePersistUserTypeReferenceListener
{
    public function __construct(private PermissionService $permissionService)
    {
    }

    /**
     * This method is triggered before a UserTypeReference entity is persisted.
     * It ensures that a UserTypePermission entity is created for each existing Permission
     * if it does not already exist.
     *
     * @param UserTypeReference $userTypeReference The UserTypeReference entity being persisted.
     */
    public function prePersist(UserTypeReference $userTypeReference): void
    {
        $this->permissionService->initPermissionGrantsByUserType($userTypeReference);
    }
}