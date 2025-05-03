<?php

namespace App\Components\Repositories;

interface IRolesPermissionsRepository
{
    public function getRoles();

    public function getRoleById($id);

    public function getRoleByName($name);

    public function getPermissions();
}
