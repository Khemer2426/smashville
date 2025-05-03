<?php

namespace App\Components\Services\Impl;

use App\Components\Repositories\IRolesPermissionsRepository;
use App\Components\Services\IRolesPermissionsService;
use App\Constants\Exception\ProcessExceptionMessage;
use App\Constants\Http\StatusCodes;
use App\Exceptions\ProcessException;

class RolesPermissionsService implements IRolesPermissionsService
{
    private $_rolesPermissionsRepository;

    public function __construct(
        IRolesPermissionsRepository $rolesPermissionsRepository
    )
    {
        $this->_rolesPermissionsRepository = $rolesPermissionsRepository;
    }

    public function getRoles()
    {
        return $this->_rolesPermissionsRepository->getRoles();
    }

    public function getRoleById($id)
    {
        return $this->_rolesPermissionsRepository->getRoleById($id);
    }

    public function getRoleByIdOrThrow($id)
    {
        $role = $this->getRoleById($id);

        if (empty($role)) {
            throw new ProcessException(
                ProcessExceptionMessage::ROLE_DOES_NOT_EXIST,
                StatusCodes::HTTP_BAD_REQUEST
            );
        }

        return $role;
    }

    public function getRoleByName($name)
    {
        return $this->_rolesPermissionsRepository->getRoleByName($name);
    }

    public function getRoleByNameOrThrow($name)
    {
        $role = $this->getRoleByName($name);

        if (empty($role)) {
            throw new ProcessException(
                ProcessExceptionMessage::ROLE_DOES_NOT_EXIST,
                StatusCodes::HTTP_BAD_REQUEST
            );
        }

        return $role;
    }

    public function getPermissions()
    {
        return $this->_rolesPermissionsRepository->getPermissions();
    }

    public function updateRolePermissions($id, $permissions)
    {
        $role = $this->getRoleByIdOrThrow($id);

        $role->syncPermissions($permissions);
    }
}