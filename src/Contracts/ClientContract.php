<?php
namespace Henrotaym\LaravelApiClient\Contracts;

use Throwable;
use Henrotaym\LaravelApiClient\Contracts\RequestContract;
use Henrotaym\LaravelApiClient\Contracts\ResponseContract;
use Henrotaym\LaravelApiClient\Contracts\CredentialContract;
use Henrotaym\LaravelApiClient\Contracts\TryResponseContract;
use Henrotaym\LaravelApiClient\Exceptions\RequestRelatedException;

interface ClientContract
{
    /** 
     * Starting a request.
     * 
     * @param RequestContract $request
     * @return ResponseContract
     */
    public function start(RequestContract $request): ResponseContract;

    /** 
     * Trying a request.
     * 
     * @param RequestContract $request
     * @param RequestRelatedException|string $exception if string given, it will be used as exception message.
     * @return TryResponseContract
     */
    public function try(RequestContract $request, $exception): TryResponseContract;

    /** 
     * Credentials associated to client.
     * 
     * @return CredentialContract|null
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