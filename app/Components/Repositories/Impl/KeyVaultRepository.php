<?php

namespace App\Components\Repositories\Impl;

use App\Components\Repositories\IKeyVaultRepository;
use GuzzleHttp\Client;

class KeyVaultRepository implements IKeyVaultRepository
{
    private $keyVaultName;
    private $clientId;
    private $clientSecret;
    private $domain_name;

    public function __construct()
    {
        $this->keyVaultName = config('vault.keyvault_name');
        $this->clientId = config('vault.client_id');
        $this->clientSecret = config('vault.client_secret');
        $this->domain_name = config('vault.domain_name');
    }

    public function getKeyVaultToken()
    {
        $guzzle = new Client();

        $token = $guzzle->post(
            "https://login.microsoftonline.com/{$this->domain_name}/oauth2/token",
            [
                'form_params' => [
                    'client_id'     => $this->clientId,
                    'client_secret' => $this->clientSecret,
                    'resource'      => 'https://vault.azure.net',
                    'grant_type'    => 'client_credentials',
                ]
            ]
        )->getBody()->getContents();

        return json_decode($token, true)['access_token'];
    }


    public function get($secretName, $accessToken)
    {
        $apiCall = "secrets/{$secretName}?api-version=2016-10-01";

        return $this->requestApi('GET', $apiCall, $accessToken);
    }


    public function addUpdate($secretName, $secretValue, $accessToken)
    {
        $apiCall = "secrets/{$secretName}?api-version=2016-10-01";

        $options = [
            'value' => $secretValue
        ];

        return $this->requestApi('PUT', $apiCall, $accessToken, $options);
    }


    public function delete($secretName, $accessToken)
    {
        $apiCall = "secrets/{$secretName}?api-version=2016-10-01";

        return $this->requestApi('DELETE', $apiCall, $accessToken);
    }


    protected function requestApi($method, $apiCall, $accessToken, $json = null)
    {
        $client = new Client(
            [
                'base_uri'    => "https://{$this->keyVaultName}.vault.azure.net/",
                'timeout'     => 2.0
            ]
        );

        try {
            $result = $client->request(
                $method,
                $apiCall,
                [
                    'headers' => [
                        'User-Agent'    => 'browser/1.0',
                        'Accept'        => 'application/json',
                        'Content-Type'  => 'application/json',
                        'Authorization' => "Bearer " . $accessToken
                    ],
                    'json' => $json
                ]
            );

            return $this->setOutput(
                $result->getStatusCode(),
                $result->getReasonPhrase(),
                json_decode($result->getBody()->getContents(), true)
            );
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            return $this->setOutput(
                $e->getResponse()->getStatusCode(),
                array_shift(json_decode($e->getResponse()->getBody()->getContents(), true))
            );
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            return $this->setOutput(
                500,
                $e->getHandlerContext()['error']
            );
        }
    }

    private function setOutput($code, $message, $data = null)
    {
        return [
                'responsecode'    => $code,
                'responseMessage' => $message,
                'data'            => $data
        ];
    }

}
