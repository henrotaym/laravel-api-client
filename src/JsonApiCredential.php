<?php

namespace Henrotaym\LaravelApiClient;

use Henrotaym\LaravelApiClient\Contracts\CredentialContract;
use Henrotaym\LaravelApiClient\Contracts\RequestContract;

/**
 * Credential setting up request to be considered as JSON API schema call.
 */
class JsonApiCredential implements CredentialContract
{
    /**
     * Preparing request.
     *
     * @return void
     */
    public function prepare(RequestContract &$request)
    {
        $request->addHeaders([
            'X-Requested-With' => 'XMLHttpRequest',
            'Accept' => 'application/vnd.api+json',
            'Content' => 'application/vnd.api+json',
            'Content-Type' => 'application/vnd.api+json',
        ]);
    }
}
