<?php
namespace Henrotaym\LaravelApiClient\Contracts;

use stdClass;
use Illuminate\Contracts\Support\Arrayable;

interface ResponseContract extends Arrayable
{
    /**
     * Telling if response can be considered as successful
     * 
     * @return bool
     */
    public function ok(): bool;
    
    /**
     * Getting response actual body.
     * 
     * @return array|null|stdClass
     */
    public function get(bool $as_array = false);
}