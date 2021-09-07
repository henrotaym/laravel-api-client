<?php
namespace Henrotaym\LaravelApiClient\Contracts;

use Henrotaym\LaravelApiClient\Contracts\RequestContract;

interface CredentialContract
{
    /**
     * Preparing request.
     */
    public function prepare(RequestContract &$request);
}