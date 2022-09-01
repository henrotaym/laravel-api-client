<?php
namespace Henrotaym\LaravelApiClient\Contracts\Encoders\_Private;

use Illuminate\Contracts\Support\Arrayable;

/**
 * Encoding to valid multipart data.
 */
interface EncoderContract
{
    /**
     * Format given data.
     * 
     * @param array|Arrayable $data
     * @return array
     */
    public function format(array|Arrayable $data): array;
}