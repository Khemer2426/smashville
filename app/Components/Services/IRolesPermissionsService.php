<?php

namespace App\Components\Services;

interface IRolesPermissionsService
{
    public function getRoles();

    public function getRoleById($id);

    public function getRoleByIdOrThrow($id);

    public function getRoleByName($name);

    public function getRoleByNameOrThrow($name);

    public function getPermissions();

    public function updateRolePermissions($id, $permissions);
}
