<?php

namespace Henrotaym\LaravelApiClient\Contracts;

use Henrotaym\LaravelApiClient\Exceptions\RequestRelatedException;

interface ClientContract
{
    /**
     * Starting a request.
     */
    public function start(RequestContract $request): ResponseContract;

    /**
     * Trying a request.
     *
     * @param  RequestRelatedException|string  $exception  if string given, it will be used as exception message.
     */
    public function try(RequestContract $request, $exception): TryResponseContract;

    /**
     * Credentials associated to client.
     */
    public function credential(): ?CredentialContract;

    /**
     * Setting credentials associated to client.
     *
     * @param CredentialContract|null
     * @return static
     */
    public function setCredential(?CredentialContract $credential): ClientContract;
}
