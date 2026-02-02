<?php

namespace Henrotaym\LaravelApiClient\Contracts\Customs;

use Henrotaym\LaravelApiClient\Contracts\RequestContract;

/**
 * Representing a custom request.
 */
interface CustomRequestContract
{
    /**
     * Getting related request.
     */
    public function getRequest(): RequestContract;
}
