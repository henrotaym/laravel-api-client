<?php

namespace Henrotaym\LaravelApiClient\Contracts;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

interface RequestContract extends Arrayable
{
    /**
     * Adding headers.
     *
     * @param  array  $headers
     * @return static
     */
    public function addHeaders($headers): RequestContract;

    /**
     * Setting bearer token in authorization header.
     *
     * @return static
     */
    public function setBearerToken(string $token): RequestContract;

    /**
     * Adding query parameters.
     *
     * @param  array  $query
     * @return static
     */
    public function addQuery($query): RequestContract;

    /**
     * Adding data.
     *
     * @param  array  $data
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
     * @param  string  $appendedUrl  Url to append.
     * @return static
     */
    public function appendToBaseUrl(string $appendedUrl): RequestContract;

    /**
     * Appending given url.
     *
     * @param  string  $appendedUrl  Url to append.
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
     * @return static
     */
    public function setIsMultipart(bool $isMultipart): RequestContract;

    /**
     * Setting request as raw.
     *
     * @return static
     */
    public function setIsRaw(bool $isRaw): RequestContract;

    /**
     * Defining authorization header as basic.
     *
     * @return static
     */
    public function setBasicAuth(string $username, string $password = ''): RequestContract;

    /**
     * Setting certificate to send with request.
     *
     * @return static
     */
    public function setCertificate(string $pathToCerficateFile, ?string $passphrase = null): RequestContract;

    /**
     * Setting ssl key to send with request.
     *
     * @return static
     */
    public function setKey(string $pathToKeyFile, ?string $passphrase = null): RequestContract;

    /**
     * Adding options to request.
     *
     * @param  array|Arrayable  $options
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
     * Setting boolean as binary (0/1) transformation..
     *
     * @param string boolean as binary (0/1) transformation.
     * @return static
     */
    public function setBooleanAsBinary(bool $booleanAsBinary): RequestContract;

    /**
     * Getting url.
     */
    public function url(): string;

    /**
     * Getting query less url.
     */
    public function queryLessUrl(): string;

    /**
     * Getting verb.
     */
    public function verb(): string;

    /**
     * Getting base url.
     */
    public function baseUrl(): ?string;

    /**
     * Getting data.
     */
    public function data(): Collection;

    /**
     * Getting headers.
     */
    public function headers(): Collection;

    /**
     * Getting attachment.
     */
    public function attachment(): ?FileContract;

    /**
     * Getting request timeout duration in seconds.
     */
    public function timeout(): ?int;

    /**
     * Getting query.
     */
    public function query(): Collection;

    /**
     * Telling if request is having attachment.
     */
    public function hasAttachment(): bool;

    /**
     * Telling if request is having headers.
     */
    public function hasHeaders(): bool;

    /**
     * Telling if request is having base url.
     */
    public function hasBaseUrl(): bool;

    /**
     * Telling if request is having data.
     */
    public function hasData(): bool;

    /**
     * Telling if request is a form.
     */
    public function isForm(): bool;

    /**
     * Telling if request is multipart.
     */
    public function isMultipart(): bool;

    /**
     * Telling if request is raw.
     */
    public function isRaw(): bool;

    /**
     * Getting request options.
     */
    public function getOptions(): Collection;

    /**
     * Telling if request is having a timeout parameter.
     */
    public function hasTimeout(): bool;

    /**
     * Telling if boolean as binary (0/1) transformation should occur.
     */
    public function hasBooleanAsBinary(): bool;
}
