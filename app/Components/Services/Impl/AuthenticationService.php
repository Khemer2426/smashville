<?php

namespace App\Components\Services\Impl;

use App\Components\Services\IAuthenticationService;
use App\Components\Services\IEmailNotificationService;
use App\Components\Services\IUniqueLinkService;
use App\Components\Services\IUserService;
use App\Constants\Components\NotificationTriggers;
use App\Constants\Components\UniqueLinkTypes;
use App\Constants\Exception\ProcessExceptionMessage;
use App\Constants\Http\StatusCodes;
use App\Exceptions\ProcessException;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AuthenticationService implements IAuthenticationService
{
    private $_userService;
    private $_uniqueLinkService;
    private $_emailNotificationService;

    public function __construct(
        IUserService $userService,
        IUniqueLinkService $uniqueLinkService,
        IEmailNotificationService $emailNotificationService
    )
    {
        $this->_userService = $userService;
        $this->_uniqueLinkService = $uniqueLinkService;
        $this->_emailNotificationService = $emailNotificationService;
    }

    public function authenticate($username, $password, $roles, $remember = false)
    {
        $credentials = [
            'username' => $username,
            'password' => $password,
            'active' => true
        ];

        $user = $this->_userService->getByUsername($username);

        if (empty($user)) {

            throw new ProcessException(
                ProcessExceptionMessage::INVALID_USER_CREDENTIALS,
                StatusCodes::HTTP_UNAUTHORIZED
            );
        }

        if (!$user->hasRole($roles)) {
            
            throw new ProcessException(
                ProcessExceptionMessage::INVALID_USER_CREDENTIALS,
                StatusCodes::HTTP_UNAUTHORIZED
            );
        }

        $encryptedPassword = md5($password);

        if ($encryptedPassword == $user->password) {
            
            Auth::loginUsingId($user->id);

            return $user;
        }

        $authorized = Auth::attempt($credentials, $remember);

        if (!$authorized) {
            
            throw new ProcessException(
                ProcessExceptionMessage::INVALID_USER_CREDENTIALS,
                StatusCodes::HTTP_UNAUTHORIZED
            );
        }

        return $user;
    }

    public function register($username, $password, $password_confirmation, $role_name)
    {
        if ($password !== $password_confirmation) {
            throw new ProcessException(
                ProcessExceptionMessage::PASSWORD_MISMATCH,
                StatusCodes::HTTP_BAD_REQUEST
            );
        }

        return DB::transaction(function () use (
            $username, 
            $password, 
            $role_name
        ) {
            $new_user = $this->_userService->createNewUser($role_name, $username, $password);

            $unique_link = $this->_uniqueLinkService->createUniqueLink($new_user->id, UniqueLinkTypes::USER_REGISTRATION);

            //Send Email notification
            $recipients = [];

            $recipients[] = $username;

            $interpolation_properties = $this->getUserRegistrationInterpolationProperties($unique_link, $new_user);

            $this->_emailNotificationService->createEmailNotification(
                $interpolation_properties,
                NotificationTriggers::ON_USER_REGISTRATION_VALUE,
                $recipients
            );

            return $new_user;
        });
    }

    public function verifyAndActivateUser($code)
    {
        $unique_link = $this->_uniqueLinkService->getValidUniqueLinkByCode($code);

        $user = $unique_link->user;

        if (!empty($user->email_verified_at)) {
            throw new ProcessException(
                ProcessExceptionMessage::USER_ALREADY_ACTIVE,
                StatusCodes::HTTP_BAD_REQUEST
            );
        }

        return DB::transaction(function () use (
            $user,
            $unique_link
        ) {
            $user->active = true;
            $user->email_verified_at = Carbon::now();
            $user->save();

            $data = $this->_userService->generateSecretKeyAndQrForUser($user->id);

            $this->_uniqueLinkService->processUniqueLink($unique_link->code);

            return $data;
        });
    }

    public function verifyAndEnableTfa($link_code, $code)
    {
        $unique_link = $this->_uniqueLinkService->getByCode($link_code);

        return DB::transaction(function () use ($unique_link, $code) {
            $user = $unique_link->user;
            $user->active = true;
            $user->email_verified_at = Carbon::now();
            $user->save();

            $this->_userService->enableTFA($user->id, $code);

            Session::forget('qr_code');
        });
    }

    public function resendRegistrationEmailByUsername($username)
    {
        $user = $this->_userService->getUserByUsername($username);

        $this->resendRegistrationEmail($user);
    }

    public function resendRegistrationEmailByUserId($user_id)
    {
        $user = $this->_userService->getUser($user_id);

        $this->resendRegistrationEmail($user);
    }

    private function resendRegistrationEmail($user)
    {
        if (!empty($user->email_verified_at)) {
            throw new ProcessException(
                ProcessExceptionMessage::USER_ALREADY_ACTIVE,
                StatusCodes::HTTP_BAD_REQUEST
            );
        }

        $uniqe_link = $this->_uniqueLinkService->getValidUniqueLinkForUser($user, UniqueLinkTypes::USER_REGISTRATION);

        DB::transaction(function() use (
            $uniqe_link,
            $user
        ) {
            if (!empty($uniqe_link)) {
                $this->_uniqueLinkService->invalidateUniqueLinkCode($uniqe_link);
            }

            $recipients = [];
            $recipients[] = $user->username;

            $new_unique_link = $this->_uniqueLinkService->createUniqueLink($user->id, UniqueLinkTypes::USER_REGISTRATION);

            if (empty($user->password)) {
                $interpolation_properties = $this->verifyRegistrationAndSetPasswordInterpolationProperties($new_unique_link, $user);
            } else {
                $interpolation_properties = $this->getUserRegistrationInterpolationProperties($new_unique_link, $user);
            }

            $this->_emailNotificationService->createEmailNotification(
                $interpolation_properties,
                NotificationTriggers::ON_USER_REGISTRATION_VALUE,
                $recipients
            );
        });
    }

    public function verifyAndSetPassword(
        $code,
        $password,
        $password_confirmation
    ) {
        $unique_link = $this->_uniqueLinkService->getValidUniqueLinkByCode($code);

        $user = $unique_link->user;

        if ($password !== $password_confirmation) {
            throw new ProcessException(
                ProcessExceptionMessage::PASSWORD_MISMATCH,
                StatusCodes::HTTP_BAD_REQUEST
            );
        }

        return DB::transaction(function() use (
            $user,
            $unique_link,
            $password
        ) {
            $user->active = true;
            $user->email_verified_at = Carbon::now();
            $user->password = bcrypt($password);
            $user->save();

            $data = $this->_userService->generateSecretKeyAndQrForUser($user->id);

            $this->_uniqueLinkService->processUniqueLink($unique_link);

            return $data;
        });
    }

    public function resetPasswordByUserId($user_id)
    {
        $user = $this->_userService->getUser($user_id);

        $this->sendResetPassword($user);
    }

    public function resetPasswordByUsername($username)
    {
        $user = $this->_userService->getUserByUsername($username);

        $this->sendResetPassword($user);
    }

    private function sendResetPassword($user, $query_string = '')
    {
        if (empty($user->email_verified_at) || !($user->active))
        {
            throw new ProcessException(
                ProcessExceptionMessage::USER_IS_NOT_ACTIVE,
                StatusCodes::HTTP_BAD_REQUEST
            );
        }

        $unique_link = $this->_uniqueLinkService->getValidUniqueLinkForUser($user, UniqueLinkTypes::RESET_PASSWORD);

        DB::transaction(function () use (
            $unique_link,
            $user,
            $query_string
        ) {
            if (!empty($unique_link)) {
                $this->_uniqueLinkService->invalidateUniqueLinkCode($unique_link);
            }

            $recipients = [];
            $recipients[] = $user->username;

            $new_unique_link = $this->_uniqueLinkService->createUniqueLink($user->id, UniqueLinkTypes::RESET_PASSWORD);

            $interpolation_properties = $this->getResetPasswordInterpolationProperties($new_unique_link, $user, $query_string);

            $this->_emailNotificationService->createEmailNotification(
                $interpolation_properties,
                NotificationTriggers::ON_RESET_PASSWORD_VALUE,
                $recipients
            );
        });
    }

    public function passwordReset(
        $code,
        $password,
        $password_confirmation
    )
    {
        $unique_link = $this->_uniqueLinkService->getValidUniqueLinkByCode($code);

        $user = $unique_link->user;

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

        return DB::transaction(function() use (
            $user,
            $unique_link,
            $password
        ) {
            $user->password = bcrypt($password);
            $user->save();

            $data = $this->_userService->generateSecretKeyAndQrForUser($user->id);

            $this->_uniqueLinkService->processUniqueLink($unique_link);

            return $data;
        });
    }

    public function logout()
    {
        Auth::logout();

        Session::forget(config('google2fa.session_var'));
        Session::forget(config('tfa_notified'));
    }

    private function getResetPasswordInterpolationProperties(
        $uniqe_link,
        $user,
        $query_string = ''
    )
    {
        $base_url = $this->getBaseUrl($user);

        $url = "{$base_url}/password/reset/{$uniqe_link->code}{$query_string}";

        return [
            'change_password_link' => $url,
            'username' => $user->username
        ];
    }

    private function getUserRegistrationInterpolationProperties(
        $uniqe_link,
        $user
    )
    {
        $base_url = $this->getBaseUrl($user);

        $url = "{$base_url}/verify/{$uniqe_link->code}";

        return [
            'user_activation_link' => $url,
            'username' => $user->username
        ];
    }

    private function verifyRegistrationAndSetPasswordInterpolationProperties(
        $uniqe_link,
        $user
    )
    {
        $base_url = $this->getBaseUrl($user);

        $url = "{$base_url}/verify/set/{$uniqe_link->code}";
        
        return [
            'user_activation_link' => $url,
            'username' => $user->username
        ];
    }

    public function getBaseUrl($user)
    {
        if ($this->_userService->isForAdmin($user)) {
            $base_url = url('/admin');
        } else {
            $base_url = url('/');
        }

        return $base_url;
    }
}
