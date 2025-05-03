<?php

namespace App\Http\Middleware;

use Closure;
use PragmaRX\Google2FA\Google2FA;
use PragmaRX\Google2FALaravel\Support\Authenticator;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FALaravel\Exceptions\InvalidSecretKey;

class Google2FAMiddleware extends Authenticator
{
    protected $google2fa;

    public function __construct()
    {
        $this->google2fa = new Google2FA();
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->boot($request);

        if ($this->isAuthenticated()) {
            return $next($request);
        }

        return $this->makeRequestOneTimePasswordResponse();
    }

    /**
     * Check if the user can pass without checking the OTP.
     *
     * @return bool
     */
    protected function canPassWithoutCheckingOTP()
    {
        $secret = $this->getUser()->tfa_secret;

        if ($secret === null || !$secret) {
            return true;
        }

        return
            !$this->getUser()->tfa_secret ||
            !$this->isEnabled() ||
            $this->noUserIsAuthenticated() ||
            $this->twoFactorAuthStillValid();
    }

    /**
     * Get the Google2FA secret key.
     *
     * @return string
     * @throws InvalidSecretKey
     */
    protected function getGoogle2FASecretKey()
    {
        $secret = $this->getUser()->tfa_secret;

        if (is_null($secret) || empty($secret)) {
            throw new InvalidSecretKey('Secret key cannot be empty.');
        }

        return $secret;
    }
}