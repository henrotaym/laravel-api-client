<?php

namespace Henrotaym\LaravelApiClient\Contracts\Customs;

use Henrotaym\LaravelApiClient\Contracts\TryResponseContract;

/**
 * Representing a custom response.
 */
interface CustomResponseContract
{
    /**
     * Getting related try response.
     *
     * @return TryResponseContract Raw Response from client.
     */
    public function getTryResponse(): TryResponseContract;
}
