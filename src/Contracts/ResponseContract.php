<?php

namespace Henrotaym\LaravelApiClient\Contracts;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Client\Response as ClientResponse;
use stdClass;

interface ResponseContract extends Arrayable
{
    /**
     * Telling if response can be considered as successful
     */
    public function ok(): bool;

    /**
     * Getting response actual body.
     *
     * @return array|null|stdClass
     */
    public function get(bool $as_array = false);

    /**
     * Getting response status code.
     */
    public function getStatusCode(): int;

    /**
     * Getting underlying response
     */
    public function response(): ClientResponse;
}
