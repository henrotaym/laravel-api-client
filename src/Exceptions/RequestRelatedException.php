<?php
namespace Henrotaym\LaravelApiClient\Exceptions;

use Exception;
use Throwable;
use Henrotaym\LaravelApiClient\Contracts\RequestContract;
use Henrotaym\LaravelApiClient\Contracts\ResponseContract;

class RequestRelatedException extends Exception
{
    /**
     * Exception message.
     * 
     * @var string
     */
    protected $message = "Request failed.";

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
     * 
     * @param RequestContract $request
     * @return self
     */
    public function setRequest(RequestContract $request): self
    {
        $this->request = $request;

        return $this;
    }

    /**
     * Setting linked response
     * 
     * @param ResponseContract $response
     * @return self
     */
    public function setResponse(ResponseContract $response): self
    {
        $this->response = $response;

        return $this;
    }

    /**
     * Setting error happening when making request.
     * 
     * @param Throwable $error
     * @return self
     */
    public function setError(Throwable $error): self
    {
        $this->error = $error;

        return $this;
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
     * 
     * @return array
     */
    public function additionalContext(): array
    {
        return [];
    }
}