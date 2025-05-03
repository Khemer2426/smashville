<?php 

namespace App\Components\Services;

interface IEncryptionService
{
    public function encryptString($string);

    public function decryptString($string);
}