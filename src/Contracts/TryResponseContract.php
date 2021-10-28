<?php
namespace Henrotaym\LaravelApiClient\Contracts;

use Henrotaym\LaravelApiClient\Contracts\ResponseContract;
use Henrotaym\LaravelApiClient\Exceptions\RequestRelatedException;

interface TryResponseContract
{
    /**
     * Error after trying the request..
     * 
     * @return RequestRelatedException|null Null if there is no exception.
     */
    public function error(): ?RequestRelatedException;

    /**
     * Response after trying the request.
     * 
     * @return ResponseContract|null Null if there is no response.
     */
    public function response(): ?ResponseContract;

    /**
     * Telling if request failed.
     * 
     * @return bool True if failed.
     */
    public function failed(): bool;

    /**
     * Telling if request was ok.
     * 
     * @return bool True if successful
     */
    public function ok(): bool;
}