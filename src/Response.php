<?php
namespace Henrotaym\LaravelApiClient;

use Henrotaym\LaravelHelpers\Facades\Helpers;
use Illuminate\Http\Client\Response as ClientResponse;
use Henrotaym\LaravelApiClient\Contracts\ResponseContract;

class Response implements ResponseContract
{
    protected $response;

    public function __construct(ClientResponse $response)
    {
        $this->response = $response;
    }

    public function response(): ClientResponse
    {
        return $this->response;
    }

    public function ok(): bool
    {
        return $this->response->ok();
    }

    public function get(bool $as_array = false)
    {
        [$error, $body] = Helpers::try(function() use ($as_array) {
            return json_decode($this->response->body(), $as_array);
        });

        if ($error):
            return null;
        endif;

        return $body;
    }
}