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
     * 
     * @return RequestContract
     */
    public function getRequest(): RequestContract;
}