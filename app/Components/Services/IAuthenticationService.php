<?php

namespace App\Components\Services;

interface IAuthenticationService
{

    public function authenticate($username, $password, $roles, $remember = false);

    public function register($username, $password, $password_confirmation, $role_name);

    public function verifyAndActivateUser($code);

    public function resendRegistrationEmailByUsername($username);

    public function resendRegistrationEmailByUserId($user_id);

    public function logout();

    public function verifyAndSetPassword(
        $code,
        $password,
        $password_confirmation
    );

    public function resetPasswordByUserId($user_id);

    public function resetPasswordByUsername($username);

    public function passwordReset(
        $code,
        $password,
        $password_confirmation
    );
}
