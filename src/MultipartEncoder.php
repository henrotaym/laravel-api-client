<?php
namespace Henrotaym\LaravelApiClient;

use Henrotaym\LaravelApiClient\Contracts\MultipartEncoderContract;
use Illuminate\Contracts\Support\Arrayable;

/**
 * Encoding to valid multipart data.
 */
class MultipartEncoder implements MultipartEncoderContract
{
    /**
     * Flatten given data.
     * 
     * @param array $data
     * @return array
     */
    public function flatten(array $data): array
    {
        return $this->flattenRecursively($data);
    }

    /**
     * Flatten recursively given data.
     * 
     * @param array $data Data to flatten
     * @param string $namespace Current namespace (should not be given)
     * @param array $flattened Current flattened representation (should not be given)
     */
    protected function flattenRecursively(
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
                $this->flattenRecursively($currentValue, $currentNamepace, $flattened)
                : $flattened[$currentNamepace] = $currentValue;
        endforeach;

        return $flattened;
    }
}