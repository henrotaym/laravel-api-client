<?php

namespace Henrotaym\LaravelApiClient;

use Henrotaym\LaravelApiClient\Contracts\ClientContract;
use Henrotaym\LaravelApiClient\Contracts\CredentialContract;
use Henrotaym\LaravelApiClient\Contracts\Encoders\JsonEncoderContract;
use Henrotaym\LaravelApiClient\Contracts\Encoders\MultipartEncoderContract;
use Henrotaym\LaravelApiClient\Contracts\RequestContract;
use Henrotaym\LaravelApiClient\Contracts\ResponseContract;
use Henrotaym\LaravelApiClient\Contracts\TryResponseContract;
use Henrotaym\LaravelApiClient\Exceptions\RequestRelatedException;
use Henrotaym\LaravelHelpers\Facades\Helpers;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response as ClientResponse;
use Illuminate\Support\Facades\Http;

class Client implements ClientContract
{
    /**
     * Credential.
     *
     * @var CredentialContract|null
     */
    protected $credential;

    /**
     * Multipart encoder.
     *
     * @var MultipartEncoderContract
     */
    protected $multipartEncoder;

    /**
     * Json encoder.
     *
     * @var JsonEncoderContract
     */
    protected $jsonEncoder;

    /**
     * Constructing client.
     *
     * @return void
     */
    public function __construct(
        ?CredentialContract $credential = null,
    ) {
        $this->credential = $credential;
        $this->multipartEncoder = app()->make(MultipartEncoderContract::class);
        $this->jsonEncoder = app()->make(JsonEncoderContract::class);
    }

    /**
     * Transforming ClientResponse to response.
     *
     * @param  ClientResponse  $response  Underlying response.
     */
    protected function response(ClientResponse $response): ResponseContract
    {
        return new Response($response);
    }

    /**
     * Starting a request.
     */
    public function start(RequestContract $request): ResponseContract
    {
        $client = $this->httpClient($request);

        $requestArgs = [$request->url()];
        $this->handleRequestData($request, $client, $requestArgs);

        $response = call_user_func_array([$client, $request->verb()], $requestArgs);

        return $this->response($response);
    }

    /**
     * Handling current request data.
     */
    protected function handleRequestData(RequestContract &$request, PendingRequest &$client, array &$requestArgs): void
    {
        if (! $request->hasData()) {
            return;
        }

        if ($request->isRaw()) {
            $client->withBody(json_encode($request->data()->all()), 'application/json');

            return;
        }

        $requestArgs[] = $request->isMultipart() ?
            $this->multipartEncoder->format($request->data(), $client, $request->hasBooleanAsBinary())
            : $this->jsonEncoder->format($request->data(), $request->hasBooleanAsBinary());
    }

    /**
     * Trying a request.
     *
     * @param  RequestRelatedException|string  $exception  if string given, it will be used as exception message.
     */
    public function try(RequestContract $request, $exception): TryResponseContract
    {
        [$error, $response] = Helpers::try(function () use (&$request) {
            return $this->start($request);
        });
        // instanciating try response
        $try_response = new TryResponse;

        // Instanciating exception
        $error_exception = is_string($exception) ? new RequestRelatedException($exception) : $exception;
        $error_exception->setRequest($request);

        if ($error) {
            // Setting error on exception
            return $try_response
                ->setError($error_exception->setError($error));
        }

        if (! $response->ok()) {
            // Setting response on exception
            return $try_response
                ->setError($error_exception->setResponse($response));
        }

        return $try_response->setResponse($response);
    }

    /**
     * Setting up underlying HTTP client.
     *
     * @param  RequestContract  $request  Request to use.
     * @return PendingRequest Request waiting to be executed.
     */
    public function httpClient(RequestContract &$request): PendingRequest
    {
        if ($this->credential) {
            $this->credential->prepare($request);
        }

        $options = $request->getOptions()->toArray();
        $isLocal = config('app.env') === 'local';

        if ($isLocal) {
            $options['verify'] = false;
        }

        if ($request->hasBaseUrl()) {
            // Appending slash if base_url doesn't end with it
            $options['base_uri'] = substr($request->baseUrl(), -1) === '/'
                ? $request->baseUrl()
                : $request->baseUrl().'/';
        }

        $client = Http::withOptions($options);

        if ($request->hasHeaders()) {
            $client->withHeaders($request->headers()->all());
        }

        if ($request->isForm()) {
            $client->asForm();
        }

        if ($request->isMultipart()) {
            $client->asMultipart();
        }

        if ($request->hasAttachment()) {
            $client->attach($request->attachment()->streamName(), $request->attachment()->stream());
        }

        if ($request->hasTimeout()) {
            $client->timeout($request->timeout());
        }

        return $client;
    }

    /**
     * Credentials associated to client.
     */
    public function credential(): ?CredentialContract
    {
        return $this->credential;
    }

    /**
     * Setting credentials associated to client.
     *
     * @param CredentialContract|null
     * @return static
     */
    public function setCredential(?CredentialContract $credential): ClientContract
    {
        $this->credential = $credential;

        return $this;
    }
}
