<?php

namespace App\Components\Services\Impl;

use App\Components\Repositories\IKeyVaultRepository;
use App\Components\Services\IKeyVaultService;
use App\Constants\Exception\ProcessExceptionMessage;
use App\Constants\Http\StatusCodes;
use App\Exceptions\ProcessException;
use Exception;

class KeyVaultService implements IKeyVaultService
{
    private $_keyVaultRepository;

    public function __construct(
      	IKeyVaultRepository $keyVaultRepository
    )
    {
        $this->_keyVaultRepository = $keyVaultRepository;
    }

    public function get($secretName)
    {
		try {
			$accessToken = $this->_keyVaultRepository->getKeyVaultToken();
			$response = $this->_keyVaultRepository->get($secretName, $accessToken)['data']['value'];
		} catch (Exception $e) {
			throw new ProcessException(
				ProcessExceptionMessage::ERROR_GET_DATA_KEYVAULT,
				500
			);
		}

		return $response;
    }
}

