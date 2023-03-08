<?php
namespace Henrotaym\LaravelApiClient;

use Henrotaym\LaravelApiClient\Contracts\ResponseContract;
use Henrotaym\LaravelApiClient\Contracts\TryResponseContract;
use Henrotaym\LaravelApiClient\Exceptions\RequestRelatedException;

class TryResponse implements TryResponseContract
{
    /**
     * Error after trying the request.
     * 
     * @var RequestRelatedException|null
     */
    protected $error;

    /**
     * Response after trying request.
     * 
     * @return ResponseContract|null
     */
    protected $response;

    /**
     * Error after trying the request.
     * 
     * @return RequestRelatedException|null Null if there is no exception.
     */
    public function error(): ?RequestRelatedException
    {
        return $this->error;
    }

    /**
     * Setting up error.
     * 
     * @param RequestRelatedException $error
     * @return TryResponseContract
     */
    public function setError(RequestRelatedException $error): TryResponseContract
    {
        $this->error = $error;

        return $this;
    }

    /**
     * Response after trying the request.
     * 
     * @return ResponseContract|null Null if there is no response.
     */
    public function response(): ?ResponseContract
    {
        return $this->response;
    }

    /**
     * Setting up response.
     * 
     * @param ResponseContract $response
     * @return TryResponseContract
     */
    public function setResponse(ResponseContract $response): TryResponseContract
    {
        $this->response = $response;

        return $this;
    }

    /**
     * Telling if request failed.
     * 
     * @return bool True if failed.
     */
    public function failed(): bool
    {
        return !$this->ok();
    }

    /**
     * Telling if request was ok.
     * 
     * @return bool True if successful
     */
    public function ok(): bool
    {
        return !$this->error && $this->response->ok();
    }

    public function body($asArray = false)
    {
        return $this->response()?->get($asArray) ?? null;
    }
}