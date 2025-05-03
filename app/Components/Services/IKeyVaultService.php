<?php

namespace App\Components\Services;

interface IKeyVaultService
{
    public function get($secretName);
}
