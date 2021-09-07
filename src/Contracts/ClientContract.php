<?php
namespace Henrotaym\LaravelApiClient\Contracts;

use Henrotaym\LaravelApiClient\Contracts\RequestContract;
use Henrotaym\LaravelApiClient\Contracts\ResponseContract;
use Henrotaym\LaravelApiClient\Contracts\CredentialContract;

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