<?php

namespace App\Components\Services;

interface IUserService
{
    public function getById($user_id);

  	public function getUser($user_id);

    public function getUserByUsername($username);

    public function getByUsername($username);

    public function getUserVM($user_id);

    public function createNewUser(
        $username, 
        $password, 
        $full_name, 
        $role_name, 
        $active
    );

	public function deactivateUser($user_id);

    public function activateUser($user_id);

    public function unlockUser($user_id);

	public function setUserPassword($user_id, $password);

    public function getUsersDatatable($keyword = null);

    public function updateUser(
        $user_id,
        $full_name, 
        $role, 
        $school, 
        $active,
        $password = null
    );

    public function deleteUser($user_id);

    public function doesUserExist($username);

    public function changePassword($user_id, $current_password, $password, $password_confirmation);

    public function generateSecretKeyAndQrForUser($user_id);

    public function enableTFA($user_id, $secret_key, $code);
    
    public function disableTFA($user_id, $password, $password_confirmation, $code);
    
    public function checkUserAndGenerateQR($user_id, $tfa_password, $tfa_password_confirmation);
}
