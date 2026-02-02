<?php

namespace Henrotaym\LaravelApiClient\Encoders;

use Henrotaym\LaravelApiClient\Contracts\Encoders\MultipartEncoderContract;
use Henrotaym\LaravelApiClient\Encoders\Traits\HasSingleValuesToFormat;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\UploadedFile;

/**
 * Encoding to valid multipart data.
 */
class MultipartEncoder implements MultipartEncoderContract
{
    use HasSingleValuesToFormat;

    /**
     * Format given data.
     */
    public function format(array|Arrayable $data, PendingRequest &$request, bool $booleanAsBinary): array
    {
        return $this->formatRecursively(
            $data instanceof Arrayable ?
                $data->toArray()
                : $data,
            $request,
            $booleanAsBinary
        );
    }

    /**
     * Formatting recursively given data.
     *
     * @param  array  $data  Data to flatten
     * @param  string  $namespace  Current namespace (should not be given)
     * @param  array  $flattened  Current flattened representation (should not be given)
     */
    protected function formatRecursively(
        array $data,
        PendingRequest &$request,
        bool $booleanAsBinary,
        string $namespace = '',
        array &$flattened = [],
    ) {
        foreach ($data as $key => $value) {
            $currentNamepace = $namespace ?
                "{$namespace}[{$key}]"
                : $key;

            $currentValue = $value instanceof Arrayable ?
                $value->toArray()
                : $value;

            if (is_array($currentValue)) {
                $this->formatRecursively($currentValue, $request, $booleanAsBinary, $currentNamepace, $flattened);
            } elseif ($value instanceof UploadedFile) {
                $request->attach($currentNamepace, $value->get(), $value->getClientOriginalName());
            } else {
                $flattened[$currentNamepace] = $this->formatSingleValue($value, $booleanAsBinary);
            }
        }

        return $flattened;
    }
}
