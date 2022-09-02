<?php
namespace Henrotaym\LaravelApiClient\Contracts\Encoders;

use Henrotaym\LaravelApiClient\Contracts\Encoders\_Private\EncoderContract;
use Illuminate\Contracts\Support\Arrayable;

/**
 * Encoding to valid json data.
 */
interface JsonEncoderContract
{
    /**
     * Format given data.
     * 
     * @param array|Arrayable $data
     * @return array
     */
    public function format(array|Arrayable $data): array;
}