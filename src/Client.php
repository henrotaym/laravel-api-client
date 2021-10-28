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

class Client implements ClientContract
{
    protected $credential;

    public function __construct(CredentialContract $credential = null)
    {
        $this->credential = $credential;
    }

    protected function response(ClientResponse $response): ResponseContract
    {
        return new Response($response);
    }

    public function start(RequestContract $request): ResponseContract
    {
        $client = $this->httpClient($request);
        
        $requestArgs = [
            $request->url()
        ];
        if ($request->hasData()):
            $requestArgs[] = $request->data()->all();
        endif;

        $response = call_user_func_array([$client, $request->verb()], $requestArgs);

        return $this->response($response);
    }

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

        if($request->hasAttachment()):
            $client->attach($request->attachment()->streamName(), $request->attachment()->stream());
        endif;

        return $client;
    }

    public function credential(): ?CredentialContract
    {
        return $this->credential;
    }

    /** 
     * Setting credentials associated to client.
     * 
     * @param CredentialContract|null
     */
    public function setCredential(?CredentialContract $credential): self
    {
        $this->credential = $credential;

        return $this;
    }
}