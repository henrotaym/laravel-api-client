<?php
namespace Henrotaym\LaravelApiClient\Contracts;

interface ResponseContract
{
    public function ok(): bool;
    
    public function get(bool $as_array = false);
}