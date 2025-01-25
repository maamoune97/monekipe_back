<?php

namespace App\Service\Permission;

use App\Entity\Permission\Permission;
use App\Entity\Permission\PermissionGrant;
use App\Entity\User\UserTypeReference;
use App\Repository\Permission\PermissionRepository;
use App\Repository\User\UserTypeReferenceRepository;
use Doctrine\ORM\EntityManagerInterface;

readonly class PermissionService
{
    public function __construct(
        private EntityManagerInterface      $entityManager,
        private UserTypeReferenceRepository $userTypeReferenceRepository,
        private PermissionRepository        $permissionRepository
    )
    {
    }

    public function initPermissionGrantsByPermission(Permission $permission): void
    {
        $userTypeReferences = $this->userTypeReferenceRepository->findAll();

        foreach ($userTypeReferences as $userTypeReference) {
            $this->createPermissionGrantIfNotExists($userTypeReference, $permission);
        }
    }

    public function initPermissionGrantsByUserType(UserTypeReference $userTypeReference): void
    {
        $permissions = $this->permissionRepository->findAll();

        foreach ($permissions as $permission) {
            $this->createPermissionGrantIfNotExists($userTypeReference, $permission);
        }
    }

    private function createPermissionGrantIfNotExists(UserTypeReference $userTypeReference, Permission $permission): void
    {
        $permissionExists = $userTypeReference->getPermissionGrants()->exists(
            fn($key, PermissionGrant $grant) => $grant->getPermission() === $permission
        );

        if (!$permissionExists) {
            $permissionGrant = (new PermissionGrant())
                ->setPermission($permission)
                ->setUserType($userTypeReference)
                ->setIsGranted(false);

            $this->entityManager->persist($permissionGrant);
        }
    }
}
