<?php

namespace App\Components\Repositories\Impl;

use App\Components\Repositories\IRolesPermissionsRepository;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesPermissionsRepository implements IRolesPermissionsRepository
{
    public function getRoles()
    {
        return Role::all();
    }

    public function getRoleById($id)
    {
        return Role::find($id);
    }

    public function getRoleByName($name)
    {
        return Role::where('name', $name)->first();
    }

    public function getPermissions()
    {
        return Permission::all();        
    }
}