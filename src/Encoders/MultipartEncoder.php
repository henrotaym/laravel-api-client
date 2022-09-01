<?php
namespace Henrotaym\LaravelApiClient\Encoders;

use Illuminate\Contracts\Support\Arrayable;
use Henrotaym\LaravelApiClient\Contracts\Encoders\MultipartEncoderContract;
use Henrotaym\LaravelApiClient\Encoders\_Private\Encoder;
use Henrotaym\LaravelApiClient\Encoders\Traits\HasSingleValuesToFormat;

/**
 * Encoding to valid multipart data.
 */
class MultipartEncoder implements MultipartEncoderContract
{
    use HasSingleValuesToFormat;

    /**
     * Format given data.
     * 
     * @param array|Arrayable $data
     * @return array
     */
    public function format(array|Arrayable $data): array
    {
        return $this->formatRecursively($data instanceof Arrayable ?
            $data->toArray()
            : $data
        );
    }

    /**
     * Formatting recursively given data.
     * 
     * @param array $data Data to flatten
     * @param string $namespace Current namespace (should not be given)
     * @param array $flattened Current flattened representation (should not be given)
     */
    protected function formatRecursively(
        array $data,
        string $namespace = "",
        array &$flattened = []
    ) {
        foreach ($data as $key => $value):
            $currentNamepace = $namespace ?
                "{$namespace}[{$key}]"
                : $key;

            $currentValue = $value instanceof Arrayable ?
                $value->toArray()
                : $value;

            is_array($currentValue) ?
                $this->formatRecursively($currentValue, $currentNamepace, $flattened)
                : $flattened[$currentNamepace] = $this->formatSingleValue($value);
        endforeach;

        return $flattened;
    }
}