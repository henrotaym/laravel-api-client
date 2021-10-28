<?php
namespace Henrotaym\LaravelApiClient\Contracts;

use Throwable;
use Henrotaym\LaravelApiClient\Contracts\RequestContract;
use Henrotaym\LaravelApiClient\Contracts\ResponseContract;
use Henrotaym\LaravelApiClient\Contracts\CredentialContract;
use Henrotaym\LaravelApiClient\Contracts\TryResponseContract;

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
     * @param Throwable|string $exception if string given, it will be used as exception message.
     * @return ResponseContract
     */
    public function try(RequestContract $request, $exception): TryResponseContract;

    /** 
     * Credentials associated to client.
     * 
     * @return ResponseContract|null
     */
    public function credential(): ?CredentialContract;

    /** 
     * Setting credentials associated to client.
     * 
     * @param CredentialContract|null
     */
    public function setCredential(?CredentialContract $credential);
}