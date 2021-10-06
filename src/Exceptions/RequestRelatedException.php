<?php
namespace Henrotaym\LaravelApiClient\Exceptions;

use Exception;
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
     * Request that actually failed.
     * 
     * @var ResponseContract
     */
    protected $response;

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
     * Exception context to log with.
     */
    public function context()
    {
        return array_merge([
            'request' => $this->request->toArray(),
            'response' => $this->response->toArray()
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