<?php
namespace Henrotaym\LaravelApiClient;

use Illuminate\Support\Facades\Http;
use Henrotaym\LaravelApiClient\Response;
use Illuminate\Http\Client\PendingRequest;
use Henrotaym\LaravelApiClient\TryResponse;
use Henrotaym\LaravelHelpers\Facades\Helpers;
use Illuminate\Http\Client\Response as ClientResponse;
use Henrotaym\LaravelApiClient\Contracts\ClientContract;
use Henrotaym\LaravelApiClient\Contracts\RequestContract;
use Henrotaym\LaravelApiClient\Contracts\ResponseContract;
use Henrotaym\LaravelApiClient\Contracts\CredentialContract;
use Henrotaym\LaravelApiClient\Contracts\TryResponseContract;
use Henrotaym\LaravelApiClient\Exceptions\RequestRelatedException;
use Henrotaym\LaravelApiClient\Contracts\Encoders\JsonEncoderContract;
use Henrotaym\LaravelApiClient\Contracts\Encoders\MultipartEncoderContract;

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
     * @param CredentialContract|null $credential
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
     * @param ClientResponse $response Underlying response.
     * @return ResponseContract
     */
    protected function response(ClientResponse $response): ResponseContract
    {
        return new Response($response);
    }
    
    /** 
     * Starting a request.
     * 
     * @param RequestContract $request
     * @return ResponseContract
     */
    public function start(RequestContract $request): ResponseContract
    {
        $client = $this->httpClient($request);
        
        $requestArgs = [
            $request->url()
        ];
        if ($request->hasData()):
            $requestArgs[] = $request->isMultipart() ?
                $this->multipartEncoder->format($request->data())
                : $this->jsonEncoder->format($request->data());
        endif;

        $response = call_user_func_array([$client, $request->verb()], $requestArgs);

        return $this->response($response);
    }

    /** 
     * Trying a request.
     * 
     * @param RequestContract $request
     * @param RequestRelatedException|string $exception if string given, it will be used as exception message.
     * @return TryResponseContract
     */
    public function try(RequestContract $request, $exception): TryResponseContract
    {
        [$error, $response] = Helpers::try(function() use (&$request) {
            return $this->start($request);
        });
        // instanciating try response
        $try_response = new TryResponse();
        
        // Instanciating exception
        $error_exception = is_string($exception) ? new RequestRelatedException($exception) : $exception;
        $error_exception->setRequest($request);

        if ($error):
            // Setting error on exception
            return $try_response
                ->setError($error_exception->setError($error));
        endif;

        if (!$response->ok()):
            // Setting response on exception
            return $try_response
                ->setError($error_exception->setResponse($response));
        endif;

        return $try_response->setResponse($response);
    }

    /**
     * Setting up underlying HTTP client.
     * 
     * @param RequestContract $request Request to use.
     * @return PendingRequest Request waiting to be executed.
     */
    public function httpClient(RequestContract &$request): PendingRequest
    {
        if ($this->credential):
            $this->credential->prepare($request);
        endif;
        
        $options = config('app.env') === 'local'
            ? ['verify' => false]
            : [];

        if ($request->hasBaseUrl()):
            // Appending slash if base_url doesn't end with it
            $options['base_uri'] = substr($request->baseUrl(), -1) === '/'
                ? $request->baseUrl()
                : $request->baseUrl() . "/"
            ;
        endif;

        $client = Http::withOptions($options);

        if ($request->hasHeaders()):
            $client->withHeaders($request->headers()->all());
        endif;

        if ($request->isForm()):
            $client->asForm();
        endif;

        if ($request->isMultipart()):
            $client->asMultipart();
        endif;

        if($request->hasAttachment()):
            $client->attach($request->attachment()->streamName(), $request->attachment()->stream());
        endif;

        return $client;
    }

    /** 
     * Credentials associated to client.
     * 
     * @return CredentialContract|null
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