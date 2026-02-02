<?php

namespace Henrotaym\LaravelApiClient\Contracts;

interface CredentialContract
{
    /**
     * Preparing request.
     *
     * @return void
     */
    public function prepare(RequestContract &$request);
}
