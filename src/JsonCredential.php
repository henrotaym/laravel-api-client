<?php
namespace Henrotaym\LaravelApiClient;

use Henrotaym\LaravelApiClient\Contracts\RequestContract;
use Henrotaym\LaravelApiClient\Contracts\CredentialContract;

/**
 * Credential setting up request to be considered as JSON call.
 */
class JsonCredential implements CredentialContract
{
    /**
     * Preparing request.
     * 
     * @param RequestContract $request
     * @return void
     */
    public function prepare(RequestContract &$request)
    {
        $request->addHeaders([
            'X-Requested-With' => "XMLHttpRequest",
            'Content-Type' => "application/json"
        ]);
    }
}