<?php 

namespace App\Components\Passive;

use Illuminate\Support\Facades\Crypt;

class Encryption {

    public static function encrypt($string)
    {
        return Crypt::encryptString($string);
    }
    
    public static function decrypt($encrypted_string)
    {
        return Crypt::decryptString($encrypted_string);
    }
}
