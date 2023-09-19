<?php
namespace Henrotaym\LaravelApiClient\Contracts;

use Illuminate\Support\Collection;
use Illuminate\Contracts\Support\Arrayable;
use Henrotaym\LaravelApiClient\Contracts\FileContract;
use Illuminate\Support\Arr;

interface RequestContract extends Arrayable
{
    /**
     * Adding headers.
     * 
     * @param array $headers
     * @return static
     */
    public function addHeaders($headers): RequestContract;

    /**
     * Setting bearer token in authorization header.
     * 
     * @param string $token
     * @return static
     */
    public function setBearerToken(string $token): RequestContract;

    /**
     * Adding query parameters.
     * 
     * @param array $query
     * @return static
     */
    public function addQuery($query): RequestContract;

    /**
     * Adding data.
     * 
     * @param array $data
     * @return static
     */
    public function addData($data): RequestContract;

    /**
     * Setting attachment.
     * 
     * @param FileContract file
     * @return static
     */
    public function setAttachment(FileContract $file): RequestContract;

    /**
     * Setting base url.
     * 
     * @param string baseUrl
     * @return static
     */
    public function setBaseUrl(string $baseUrl): RequestContract;

    /**
     * Appending given url to base url.
     * 
     * @param string $appendedUrl Url to append.
     * @return static
     */
    public function appendToBaseUrl(string $appendedUrl): RequestContract;

    /**
     * Appending given url.
     * 
     * @param string $appendedUrl Url to append.
     * @return static
     */
    public function appendToUrl(string $appendedUrl): RequestContract;
    
    /**
     * Setting url.
     * 
     * @param string url
     * @return static
     */
    public function setUrl(string $url): RequestContract;
    
    /**
     * Setting verb.
     * 
     * @param string verb
     * @return static
     */
    public function setVerb(string $verb): RequestContract;
    
    /**
     * Setting if request should be sent as form.
     * 
     * @param bool isForm
     * @return static
     */
    public function setIsForm(bool $isForm): RequestContract;

    /**
     * Setting request as multipart.
     * 
     * @param bool $isMultipart
     * @return static
     */
    public function setIsMultipart(bool $isMultipart): RequestContract;

    /**
     * Setting request as raw.
     * 
     * @param bool $isRaw
     * @return static
     */
    public function setIsRaw(bool $isRaw): RequestContract;

    /**
     * Defining authorization header as basic.
     * 
     * @param string $username
     * @param string $password
     * @return static
     */
    public function setBasicAuth(string $username, string $password = ""): RequestContract;

    /**
     * Setting certificate to send with request.
     * 
     * @param string $pathToCerficateFile
     * @param ?string $passphrase
     * @return static
     */
    public function setCertificate(string $pathToCerficateFile, ?string $passphrase = null): RequestContract;

    /**
     * Setting ssl key to send with request.
     * 
     * @param string $pathToKeyFile
     * @param ?string $passphrase
     * @return static
     */
    public function setKey(string $pathToKeyFile, ?string $passphrase = null): RequestContract;

    /**
     * Adding options to request.
     * 
     * @param array|Arrayable $options
     * @return static
     */
    public function addOptions($options): RequestContract;

    /**
     * Setting url.
     * 
     * @param string url
     * @return static
     */
    public function setTimeout(int $durationInSeconds): RequestContract;
    
    /**
     * Getting url.
     * 
     * @return string
     */
    public function url(): string;

    /**
     * Getting query less url.
     * 
     * @return string
     */
    public function queryLessUrl(): string;

    /**
     * Getting verb.
     * 
     * @return string
     */
    public function verb(): string;

    /**
     * Getting base url.
     * 
     * @return string|null
     */
    public function baseUrl(): ?string;

    /**
     * Getting data.
     * 
     * @return Collection
     */
    public function data(): Collection;

    /**
     * Getting headers.
     * 
     * @return Collection
     */
    public function headers(): Collection;

    /**
     * Getting attachment.
     * 
     * @return FileContract|null
     */
    public function attachment(): ?FileContract;

    /**
     * Getting request timeout duration in seconds.
     * 
     * @return int
     */
    public function timeout(): ?int;

    /**
     * Getting query.
     * 
     * @return Collection
     */
    public function query(): Collection;

    /**
     * Telling if request is having attachment.
     * 
     * @return bool
     */
    public function hasAttachment(): bool;

    /**
     * Telling if request is having headers.
     * 
     * @return bool
     */
    public function hasHeaders(): bool;

    /**
     * Telling if request is having base url.
     * 
     * @return bool
     */
    public function hasBaseUrl(): bool;

    /**
     * Telling if request is having data.
     * 
     * @return bool
     */
    public function hasData(): bool;

    /**
     * Telling if request is a form.
     * 
     * @return bool
     */
    public function isForm(): bool;

    /**
     * Telling if request is multipart.
     * 
     * @return bool
     */
    public function isMultipart(): bool;

    /**
     * Telling if request is raw.
     * 
     * @return bool
     */
    public function isRaw(): bool;

    /**
     * Getting request options.
     * 
     * @return Collection
     */
    public function getOptions(): Collection;
    
    /**
     * Telling if request is having a timeout parameter.
     * 
     * @return bool
     */
    public function hasTimeout(): bool;
}
