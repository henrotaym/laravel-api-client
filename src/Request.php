<?php
namespace Henrotaym\LaravelApiClient;

use Illuminate\Support\Collection;
use Henrotaym\LaravelApiClient\Contracts\FileContract;
use Henrotaym\LaravelApiClient\Contracts\RequestContract;

class Request implements RequestContract
{
    protected
        /**
         * Request GET data
         * @var Collection
         */
        $query,
        /**
         * Request headers
         * @var Collection
         */
        $headers,
        /**
         * Request POST data
         * @var Collection
         */
        $data,
        /**
         * Request should be sent as form data
         * @var bool
         */
        $isForm = false,
        /**
         * Request attachment
         * @var ?FileContract
         */
        $attachment,
        /**
         * Request URL
         * @var string
         */
        $url,
        /**
         * Request base url
         * @var string
         */
        $baseUrl,
        /**
         * Request verb("GET", "POST",...)
         * @var string
         */
        $verb = "GET"
    ;

    public function __construct()
    {
        $this->query = collect();
        $this->data = collect();
        $this->headers = collect();
    }

    public function setVerb(string $verb): self
    {
        $this->verb = strtoupper($verb);
        
        return $this;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;
        
        return $this;
    }

    public function addHeaders($headers): self
    {
        $this->headers = $this->headers->merge( 
            is_array($headers) 
                ? $headers 
                : $headers->toArray()
        );
    
        return $this;
    }

    public function addQuery($query): self
    {
        $this->query = $this->query
            ->merge( 
                is_array($query) 
                    ? $query 
                    : $query->toArray()
            );
        
        return $this;
    }

    public function addData($data): self
    {
        $this->data = $this->data->merge( is_array($data) 
            ? $data 
            : $data->toArray()
        );
        
        return $this;
    }

    public function setAttachment(FileContract $file): self
    {
        $this->attachment = $file;
        
        return $this;
    }

    public function setBaseUrl(string $baseUrl): self
    {
        $this->baseUrl = $baseUrl;
        
        return $this;
    }
    
    public function setIsForm(bool $isForm): self
    {
        $this->isForm = $isForm;
        
        return $this;
    }
    
    public function url(): string
    {
        $hasQuery = strpos($this->url, '?') !== false;
        $isFirstIteration = true;
        
        return $this->query->reduceWithKeys(function($url, $value, $name) use (&$isFirstIteration, &$hasQuery) {
            if (!$hasQuery && $isFirstIteration):
                $url = "$url?";
                $isFirstIteration = false;
                $hasQuery = true;
            else:
                $url = "$url&";
            endif;

            return "$url$name=$value";
        }, $this->url);
    }

    public function verb(): string
    {
        return $this->verb;
    }

    public function baseUrl(): ?string
    {
        return $this->baseUrl;
    }

    public function data(): Collection
    {
        return $this->data;
    }

    public function headers(): Collection
    {
        return $this->headers;
    }

    public function attachment(): ?FileContract
    {
        return $this->attachment;
    }

    public function hasAttachment(): bool
    {
        return $this->attachment instanceof FileContract;
    }

    public function hasHeaders(): bool
    {
        return $this->headers->isNotEmpty();
    }

    public function hasBaseUrl(): bool
    {
        return is_string($this->baseUrl) 
            && strlen($this->baseUrl) > 0;
    }

    public function hasData(): bool
    {
        return $this->verb !== 'GET'
            && $this->data->isNotEmpty();
    }

    public function isForm(): bool
    {
        return $this->isForm;
    }
    
}
