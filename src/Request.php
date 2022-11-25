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
         * Request should be sent as multi-part form data.
         * @var bool
         */
        $isMultipart = false,
        /**
         * Request should be sent as raw data.
         * @var bool
         */
        $isRaw = false,
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

    /**
     * Constructing instance.
     * 
     * @return void
     */
    public function __construct()
    {
        $this->query = collect();
        $this->data = collect();
        $this->headers = collect();
    }

    /**
     * Setting verb.
     * 
     * @param string verb
     * @return static
     */
    public function setVerb(string $verb): RequestContract
    {
        $this->verb = strtoupper($verb);
        
        return $this;
    }

    /**
     * Setting url.
     * 
     * @param string url
     * @return static
     */
    public function setUrl(string $url): RequestContract
    {
        $this->url = $url;
        
        return $this;
    }

    /**
     * Adding headers.
     * 
     * @param array $headers
     * @return static
     */
    public function addHeaders($headers): RequestContract
    {
        $this->headers = $this->headers->merge( 
            is_array($headers) 
                ? $headers 
                : $headers->toArray()
        );
    
        return $this;
    }

    /**
     * Adding query parameters.
     * 
     * @param array $query
     * @return static
     */
    public function addQuery($query): RequestContract
    {
        $this->query = $this->query
            ->merge( 
                is_array($query) 
                    ? $query 
                    : $query->toArray()
            );
        
        return $this;
    }

    /**
     * Adding data.
     * 
     * @param array $data
     * @return static
     */
    public function addData($data): RequestContract
    {
        $this->data = $this->data->merge( is_array($data) 
            ? $data 
            : $data->toArray()
        );
        
        return $this;
    }

    /**
     * Setting attachment.
     * 
     * @param FileContract file
     * @return static
     */
    public function setAttachment(FileContract $file): RequestContract
    {
        $this->attachment = $file;
        
        return $this;
    }

    /**
     * Setting base url.
     * 
     * @param string baseUrl
     * @return static
     */
    public function setBaseUrl(string $baseUrl): RequestContract
    {
        $this->baseUrl = $baseUrl;
        
        return $this;
    }
    
    /**
     * Setting if request should be sent as form.
     * 
     * @param bool isForm
     * @return static
     */
    public function setIsForm(bool $isForm): RequestContract
    {
        $this->isForm = $isForm;
        
        return $this;
    }

    /**
     * Setting request as multipart.
     * 
     * @param bool $isMultipart
     * @return static
     */
    public function setIsMultipart(bool $isMultipart): RequestContract
    {
        $this->isMultipart = $isMultipart;

        return $this;
    }

    /**
     * Setting request as multipart.
     * 
     * @param bool $isRaw
     * @return static
     */
    public function setIsRaw(bool $isRaw): RequestContract
    {
        $this->isRaw = $isRaw;

        return $this;
    }

    /**
     * Defining authorization header as basic.
     * 
     * @param string $username
     * @param string $password
     * @return static
     */
    public function setBasicAuth(string $username, string $password = ""): RequestContract
    {
        $to_encode = "$username" . ($password ? ":$password" : "");
        return $this->addHeaders(['Authorization' => "Basic " . base64_encode($to_encode)]);
    }
    
    /**
     * Getting url.
     * 
     * @return string
     */
    public function url(): string
    {
        if ($this->query->isEmpty()):
            return $this->url;
        endif;
        
        $has_query = strpos($this->url, '?') !== false;
        $query = http_build_query($this->query->all());

        return $this->url . ($has_query ? "&" : "?") . $query;
    }

    /**
     * Getting verb.
     * 
     * @return string
     */
    public function verb(): string
    {
        return $this->verb;
    }

    /**
     * Getting base url.
     * 
     * @return string|null
     */
    public function baseUrl(): ?string
    {
        return $this->baseUrl;
    }

    /**
     * Getting data.
     * 
     * @return Collection
     */
    public function data(): Collection
    {
        return $this->data;
    }

    /**
     * Getting headers.
     * 
     * @return Collection
     */
    public function headers(): Collection
    {
        return $this->headers;
    }

    /**
     * Getting attachment.
     * 
     * @return FileContract|null
     */
    public function attachment(): ?FileContract
    {
        return $this->attachment;
    }

    /**
     * Telling if request is having attachment.
     * 
     * @return bool
     */
    public function hasAttachment(): bool
    {
        return $this->attachment instanceof FileContract;
    }

    /**
     * Telling if request is having headers.
     * 
     * @return bool
     */
    public function hasHeaders(): bool
    {
        return $this->headers->isNotEmpty();
    }

    /**
     * Telling if request is having base url.
     * 
     * @return bool
     */
    public function hasBaseUrl(): bool
    {
        return is_string($this->baseUrl) 
            && strlen($this->baseUrl) > 0;
    }

    /**
     * Telling if request is having data.
     * 
     * @return bool
     */
    public function hasData(): bool
    {
        return $this->verb !== 'GET'
            && $this->data->isNotEmpty();
    }

    /**
     * Telling if request is a form.
     * 
     * @return bool
     */
    public function isForm(): bool
    {
        return $this->isForm;
    }

    /**
     * Telling if request is multipart.
     * 
     * @return bool
     */
    public function isMultipart(): bool
    {
        return $this->isMultipart;
    }

    /**
     * Telling if request is raw.
     * 
     * @return bool
     */
    public function isRaw(): bool
    {
        return $this->isRaw;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'base_url' => $this->baseUrl(),
            'url' => $this->url(),
            'headers' => $this->headers()->toArray(),
            'data' => $this->data()->toArray(),
            'query' => $this->query->toArray(),
            'verb' => $this->verb(),
            'is_form' => $this->isForm(),
            'is_multipart' => $this->isMultipart(),
            'is_raw' => $this->isRaw(),
            'has_attachment' => $this->hasAttachment()
        ];
    }
    
}
