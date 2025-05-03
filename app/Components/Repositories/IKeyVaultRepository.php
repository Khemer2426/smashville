<?php

namespace App\Components\Repositories;

interface IKeyVaultRepository
{
    public function getKeyVaultToken();

    public function get($secretName, $accessToken);

    public function addUpdate($secretName, $secretValue, $accessToken);

    public function delete($secretName, $accessToken);
}
