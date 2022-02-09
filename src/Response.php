<?php
namespace Henrotaym\LaravelApiClient;

use Henrotaym\LaravelHelpers\Facades\Helpers;
use Illuminate\Http\Client\Response as ClientResponse;
use Henrotaym\LaravelApiClient\Contracts\ResponseContract;

class Response implements ResponseContract
{
    /**
     * Underlying response
     * 
     * @var ClientResponse
     */
    protected $response;

    /**
     * Constructing response 
     * 
     * @param ClientResponse $response Underlying response.
     */
    public function __construct(ClientResponse $response)
    {
        $this->response = $response;
    }

    /** 
     * Getting underlying response
     * 
     * @return ClientResponse
     */
    public function response(): ClientResponse
    {
        return $this->response;
    }

    /**
     * Telling if response can be considered as successful
     * 
     * @return bool
     */
    public function ok(): bool
    {
        return $this->response->successful();
    }

    /**
     * Getting response actual body.
     * 
     * @return array|null|stdClass
     */
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

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            "ok" => $this->ok(),
            "body" => $this->get(true)
        ];
    }
}