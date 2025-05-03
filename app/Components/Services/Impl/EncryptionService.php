<?php

namespace App\Components\Services\Impl;

use App\Components\Services\IEncryptionService;
use App\Components\Services\IKeyVaultService;
use Illuminate\Encryption\Encrypter;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class EncryptionService implements IEncryptionService {

    public $_keyVaultService;

    public function __construct(
        IKeyVaultService $keyVaultService
    )
    {
        $this->_keyVaultService = $keyVaultService;
    }

    private function getKey()
    {
        return config('app.encrypt_key');
    }

    public function encryptString($string)
    {
        $encrypter = new Encrypter($this->getKey(), config('app.cipher'));

        return $encrypter->encrypt($string);
    }

    public function decryptString($string)
    {
        $encrypter = new Encrypter($this->getKey(), config('app.cipher'));
        
        return $encrypter->decrypt($string);
    }
}
