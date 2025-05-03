<?php

namespace App\Components\Services\Impl;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Exceptions\ProcessException;
use App\Constants\Http\StatusCodes;

use App\Components\Repositories\IUserRepository;
use App\Components\Services\IRolesPermissionsService;
use App\Components\Services\ITwoFactorAuthService;
use App\Components\Services\IUserService;
use App\Constants\Exception\ProcessExceptionMessage;
use App\Models\ViewModels\UserVM;

class UserService implements IUserService
{
	private $_userRepository;
    private $_rolesPermissionsService;
    private $_twoFactorAuthService;

    public function __construct(
        IUserRepository $userRepository,
        IRolesPermissionsService $rolesPermissionsService,
        ITwoFactorAuthService $twoFactorAuthService
    )
    {
        $this->_userRepository = $userRepository;
        $this->_rolesPermissionsService = $rolesPermissionsService;
        $this->_twoFactorAuthService = $twoFactorAuthService;
    }

    public function getById($user_id)
    {
        return $this->_userRepository->getUser($user_id);
    }

    public function getUser($user_id)
    {
        $user = $this->_userRepository->getUser($user_id);

        if (empty($user)) {
            throw new ProcessException(
                ProcessExceptionMessage::USER_DOES_NOT_EXIST,
                StatusCodes::HTTP_BAD_REQUEST
            );
        }

        return $user;
    }

    public function getUserByUsername($username)
    {
        $user = $this->_userRepository->getUserByUsername($username);

        if (empty($user)) {
            throw new ProcessException(
                ProcessExceptionMessage::USER_DOES_NOT_EXIST,
                StatusCodes::HTTP_BAD_REQUEST
            );
        }

        return $user;
    }

    public function getByUsername($username)
    {
        return $this->_userRepository->getUserByUsername($username);
    }

    public function getUserVM($user_id)
    {
        $user = $this->getUser($user_id);

        $userVM = new UserVM(
            $user->id,
            $user->username,
            $user->user_fullname,
            $user->getRoleNames()->toArray(),
            $user->school,
            $user->active,
            $user->schools
        );

        return $userVM;
    }

    public function createNewUser(
        $username, 
        $password, 
        $full_name, 
        $role_name, 
        $active
    )
    {

        if ($this->doesUserExist($username)) {
            throw new ProcessException(
                ProcessExceptionMessage::USER_ALREADY_EXISTS,
                StatusCodes::HTTP_BAD_REQUEST
            );
        }

        $this->_rolesPermissionsService->getRoleByNameOrThrow($role_name);

        $user =  $this->_userRepository->createUser(
            $username,
            $password,
            $full_name,
            $role_name,
            $active
        );

        $user->assignRole($role_name);
        
        return $user;
    }

    public function doesUserExist($username)
    {
        return !empty($this->_userRepository->getUserByUsername($username));
    }

    public function deactivateUser($user_id)
    {
        $user = $this->getUser($user_id);
        $user->active = 0;
        $user->save();
    }

    public function activateUser($user_id)
    {
        $user = $this->getUser($user_id);
        $user->active = 1;
        $user->save();
    }

    public function unlockUser($user_id)
    {
        $user = $this->getUser($user_id);
        $user->user_fail = 0;
        $user->save();
    }

    public function setUserPassword($user_id, $password)
    {
        $user = $this->getUser($user_id);
        $user->password = $password;
        $user->save();
    }

    public function getUsersDatatable($keyword = null)
    {
        return $this->_userRepository->getUsersDatatable($keyword);
    }

    public function changePassword($user_id, $current_password, $password, $password_confirmation)
    {
        $user = $this->getUser($user_id);

        if (!($user->active)) {
            throw new ProcessException(
                ProcessExceptionMessage::USER_IS_NOT_ACTIVE,
                StatusCodes::HTTP_BAD_REQUEST
            );
        }

        if ($password !== $password_confirmation) {
            throw new ProcessException(
                ProcessExceptionMessage::PASSWORD_MISMATCH,
                StatusCodes::HTTP_BAD_REQUEST
            );
        }

        if (md5($current_password) != $user->password && !Hash::check($current_password, $user->password)) {
            throw new ProcessException(
                ProcessExceptionMessage::CURRENT_PASSWORD_INVALID,
                StatusCodes::HTTP_BAD_REQUEST
            );
        }

        $user->password = bcrypt($password);
        $user->save();
    }

    public function updateUser(
        $user_id,
        $full_name, 
        $role, 
        $school, 
        $active,
        $password = null
    )
    {
        $user = $this->getUser($user_id);

        $this->_rolesPermissionsService->getRoleByNameOrThrow($role);

        $user->user_fullname = $full_name;
        $user->user_jobrole = $role;
        $user->user_school = $school;
        $user->active = $active;

        if (!empty($password)) {
            $user->password = bcrypt($password);
        }

        $user->save();

        $user->syncRoles([$role]);
        $user->refresh();

        return $user;
    }

    public function deleteUser($user_id)
    {
        $user = $this->getUser($user_id);

        if (Auth::user()->id == $user_id) {
            throw new ProcessException(
                ProcessExceptionMessage::ACTION_NOT_ALLOWED,
                StatusCodes::HTTP_BAD_REQUEST
            );
        }

        $user->delete();
    }

    public function generateSecretKeyAndQrForUser($user_id)
    {
        $user = $this->getUser($user_id);

        $secretKey = $this->_twoFactorAuthService->generateSecretKey($user_id);

        $qrCodeUrl = $this->_twoFactorAuthService->generateQrCode(
            $user->username,
            $secretKey
        );

        return [
            'user_id' => $user->id,
            'secret' => $secretKey,
            'qrCodeUrl' => $qrCodeUrl
        ];
    }

    public function checkUserAndGenerateQR($user_id, $password, $password_confirmation)
    {
        $user = $this->getUser($user_id);

        if (empty($user->email_verified_at) || !($user->active)) {
            throw new ProcessException(
                ProcessExceptionMessage::USER_IS_NOT_ACTIVE,
                StatusCodes::HTTP_BAD_REQUEST
            );
        }

        if ($password !== $password_confirmation) {
            throw new ProcessException(
                ProcessExceptionMessage::PASSWORD_MISMATCH,
                StatusCodes::HTTP_BAD_REQUEST
            );
        }

        if (!Hash::check($password, $user->password)) {
            throw new ProcessException(
                ProcessExceptionMessage::CURRENT_PASSWORD_INVALID,
                StatusCodes::HTTP_BAD_REQUEST
            );
        }

        return $this->generateSecretKeyAndQrForUser($user->id);
    }

    public function enableTFA($user_id, $secret_key, $code)
    {
        $user = $this->getUser($user_id);

        if (empty($user->email_verified_at) || !($user->active)) {
            throw new ProcessException(
                ProcessExceptionMessage::USER_IS_NOT_ACTIVE,
                StatusCodes::HTTP_BAD_REQUEST
            );
        }

        if (!$this->_twoFactorAuthService->isCodeValid($secret_key, $code)) {
            throw new ProcessException(
                ProcessExceptionMessage::CODE_IS_INVALID,
                StatusCodes::HTTP_BAD_REQUEST
            );
        }

        $user->tfa_notified = 1;
        $user->tfa_secret = $secret_key;
        $user->save();

        Session::put(config('google2fa.session_var'), [
            'auth_passed' => true,
            'auth_time' => now()->toIso8601String()
        ]);
    }

    public function disableTFA($user_id, $password, $password_confirmation, $code)
    {
        $user = $this->getUser($user_id);

        if (empty($user->email_verified_at) || !($user->active)) {
            throw new ProcessException(
                ProcessExceptionMessage::USER_IS_NOT_ACTIVE,
                StatusCodes::HTTP_BAD_REQUEST
            );
        }

        if ($password !== $password_confirmation) {
            throw new ProcessException(
                ProcessExceptionMessage::PASSWORD_MISMATCH,
                StatusCodes::HTTP_BAD_REQUEST
            );
        }

        if (!Hash::check($password, $user->password)) {
            throw new ProcessException(
                ProcessExceptionMessage::CURRENT_PASSWORD_INVALID,
                StatusCodes::HTTP_BAD_REQUEST
            );
        }

        if (!$this->_twoFactorAuthService->isCodeValid($user->tfa_secret, $code)) {
            throw new ProcessException(
                ProcessExceptionMessage::CODE_IS_INVALID,
                StatusCodes::HTTP_BAD_REQUEST
            );
        }

        $user->tfa_secret = null;
        $user->save();

        Session::forget(config('google2fa.session_var'));
    }

    public function disableTFAById($user_id)
    {
        $user = $this->getUser($user_id);
        $user->tfa_secret = null;
        $user->save();
    }

    public function setTFANotified($user_id)
    {
        $user = $this->getUser($user_id);
        $user->tfa_notified = 1;
        $user->save();
    }
}
