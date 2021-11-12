<?php
namespace Henrotaym\LaravelApiClient\Contracts;

use Henrotaym\LaravelApiClient\Contracts\RequestContract;

interface CredentialContract
{
    /**
     * Preparing request.
     * 
     * @param RequestContract $request
     * @return void
     */
    public function prepare(RequestContract &$request);
}