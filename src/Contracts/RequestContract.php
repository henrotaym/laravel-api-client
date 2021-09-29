<?php
namespace Henrotaym\LaravelApiClient\Contracts;

use Illuminate\Support\Collection;
use Illuminate\Contracts\Support\Arrayable;
use Henrotaym\LaravelApiClient\Contracts\FileContract;

interface RequestContract extends Arrayable
{
    public function addHeaders($headers);

    public function addQuery($query);

    public function addData($data);

    public function setAttachment(FileContract $file);

    public function setBaseUrl(string $baseUrl);

    public function setUrl(string $url);
    
    public function setVerb(string $verb);
    
    public function setIsForm(bool $isForm);

    /**
     * Defining authorization header as basic.
     * 
     * @param string $username
     * @param string $password
     */
    public function setBasicAuth(string $username, string $password = "");
    
    public function url(): string;

    public function verb(): string;

    public function baseUrl(): ?string;

    public function data(): Collection;

    public function headers(): Collection;

    public function attachment(): ?FileContract;

    public function hasAttachment(): bool;

    public function hasHeaders(): bool;

    public function hasBaseUrl(): bool;

    public function hasData(): bool;

    public function isForm(): bool;
}
