<?php

namespace App\Components\Services;

interface ITwoFactorAuthService
{
    public function generateSecretKey();

    public function generateQrCode(
        $email,
        $secretKey
    );

    public function isCodeValid($secretKey, $code);
}