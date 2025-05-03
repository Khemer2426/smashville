<?php

namespace App\Components\Repositories;

interface IUserRepository
{
    public function createUser(
        $username, 
        $password, 
        $full_name, 
        $role_name, 
        // $school_id, 
        $active
    );

    public function deactivateUser($user_id);

    public function activateUser($user_id);

    public function setUserPassword($user_id, $password);

    public function getUser($user_id);

    public function getUserByUsername($username);

    public function getUsersDatatable($keyword = null);

    public function deleteUser($user_id);
}
