<?php
namespace Henrotaym\LaravelApiClient;

use GuzzleHttp\RequestOptions;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;
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
         * Request options
         * @var Collection
         */
        $options,
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
        $verb = "GET",
        /**
         * Request timeout in seconds
         * @var ?string
         */
        $timeoutDuration = null
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
        $this->options = collect();
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
     * @param array|Arrayable|JsonResource $data
     * @return static
     */
    public function addData($data): RequestContract
    {
        $this->data = $this->data->merge($this->getFormatedData($data));
        
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

    public function appendToUrl(string $appendedUrl): RequestContract
    {
        return $this->setUrl(
            $this->concatUrls($this->url, $appendedUrl)
        );
    }

    public function appendToBaseUrl(string $appendedUrl): RequestContract
    {
        return $this->setBaseUrl(
            $this->concatUrls($this->baseUrl, $appendedUrl)
        );
    }

    /**
     * Concatening url parts correctly.
     * 
     * @param ?string $url
     * @param string $appendedUrl
     */
    protected function concatUrls(?string $url, string $appendedUrl): string
    {
        if (!$url) return $appendedUrl;

        $endingWithSlash = Str::endsWith($url, "/");

        return $url . ($endingWithSlash ? "" : "/") . $appendedUrl;
    }

    /**
     * Getting formated data for addData method.
     * 
     * @param array|Arrayable|JsonResource $data
     * @return array
     */
    protected function getFormatedData($data): array
    {
        if (is_array($data)) return $data;
        if ($data instanceof Arrayable) return $data->toArray();
        if ($data instanceof JsonResource) return $data->toArray(request());

        return [];
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

    public function setBearerToken(string $token): RequestContract
    {
        $authorization = "Bearer " . str_replace("Bearer ", "", $token);

        return $this->addHeaders(["Authorization" => $authorization]);
    }

    public function setCertificate(string $path, ?string $passphrase = null): RequestContract
    {
        $value = $this->getFormatedKeyOrCertificate($path, $passphrase);

        return $this->addOptions([RequestOptions::CERT => $value]);
    }

    public function setKey(string $path, ?string $passphrase = null): RequestContract
    {
        $value = $this->getFormatedKeyOrCertificate($path, $passphrase);

        return $this->addOptions([RequestOptions::SSL_KEY => $value]);
    }

    public function addOptions($options): RequestContract
    {
        $this->options = $this->options->merge( 
            is_array($options)
                ? $options 
                : $options->toArray()
        );
    
        return $this;
    }


    /**
     * @return string|array
     */
    protected function getFormatedKeyOrCertificate(string $path, ?string $passphrase = null)
    {
        return $passphrase
            ? [$path, $passphrase]
            : $path;
    }
    
    public function setTimeout(int $durationInSeconds): RequestContract
    {
        $this->timeoutDuration = $durationInSeconds;

        return $this;
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

    public function queryLessUrl(): string
    {
        return Str::before($this->url, "?");
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

    public function timeout(): ?int
    {
        return $this->timeoutDuration;
    }

    public function query(): Collection
    {
        return $this->query;
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

    public function getOptions(): Collection
    {
        return $this->options;
    }
    
    public function hasTimeout(): bool
    {
        return !!$this->timeoutDuration;
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
            'timeout' => $this->timeout(),
            'headers' => $this->headers()->toArray(),
            'data' => $this->data()->toArray(),
            'query' => $this->query->toArray(),
            'verb' => $this->verb(),
            'is_form' => $this->isForm(),
            'is_multipart' => $this->isMultipart(),
            'is_raw' => $this->isRaw(),
            'has_attachment' => $this->hasAttachment(),
            'options' => $this->options->toArray()
        ];
    }
    
}
