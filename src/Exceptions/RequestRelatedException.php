<?php

namespace Henrotaym\LaravelApiClient\Exceptions;

use Exception;
use Henrotaym\LaravelApiClient\Contracts\RequestContract;
use Henrotaym\LaravelApiClient\Contracts\ResponseContract;
use Throwable;

class RequestRelatedException extends Exception
{
    /**
     * Exception message.
     *
     * @var string
     */
    protected $message = 'Request failed.';

    /**
     * Request that actually failed.
     *
     * @var RequestContract
     */
    protected $request;

    /**
     * Response sent back. Null meaning failure before even making request to resource.
     *
     * @var ResponseContract|null
     */
    protected $response;

    /**
     * Potential error happening before making request.
     *
     * @var Throwable|null Null if no exception during process.
     */
    protected $error;

    /**
     * Setting linked request
     */
    public function setRequest(RequestContract $request): self
    {
        $this->request = $request;

        return $this;
    }

    /**
     * Setting linked response
     */
    public function setResponse(ResponseContract $response): self
    {
        $this->response = $response;

        return $this;
    }

    /**
     * Setting error happening when making request.
     */
    public function setError(Throwable $error): self
    {
        $this->error = $error;

        return $this;
    }

    /**
     * Getting related response if any.
     */
    public function getResponse(): ?ResponseContract
    {
        return $this->response;
    }

    /**
     * Getting related error if any.
     */
    public function getError(): ?Throwable
    {
        return $this->error;
    }

    /**
     * Telling if related to any error.
     */
    public function hasError(): bool
    {
        return (bool) $this->error;
    }

    /**
     * Telling if related to any response.
     */
    public function hasResponse(): bool
    {
        return (bool) $this->response;
    }

    /**
     * Exception context to log with.
     */
    public function context()
    {
        return array_merge([
            'request' => $this->request->toArray(),
            'response' => optional($this->response)->toArray(),
            'error' => optional($this->error)->getMessage(),
        ], $this->additionalContext());
    }

    /**
     * Exception additional context.
     */
    public function additionalContext(): array
    {
        return [];
    }
}
