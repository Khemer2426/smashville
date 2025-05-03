<?php

namespace App\Components\Services\Impl;

use App\Components\Services\ITwoFactorAuthService;
use chillerlan\QRCode\QRCode;
use PragmaRX\Google2FA\Google2FA;

class TwoFactorAuthService implements ITwoFactorAuthService
{
    private $_google2fa;

    public function __construct()
    {
        $this->_google2fa = new Google2FA();
    }

    public function generateSecretKey()
    {
        return $this->_google2fa->generateSecretKey();
    }

    public function generateQrCode(
        $email,
        $secretKey
    )
    {
        $url = $this->_google2fa->getQRCodeUrl(
            config('app.name'),
            $email,
            $secretKey
        );

        return (new QRCode())->render($url);
    }

    public function isCodeValid($secretKey, $code)
    {
        return $this->_google2fa->verifyKey($secretKey, $code);
    }
}