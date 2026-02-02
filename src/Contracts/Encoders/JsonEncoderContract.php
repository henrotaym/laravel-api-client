<?php

namespace Henrotaym\LaravelApiClient\Contracts\Encoders;

use Illuminate\Contracts\Support\Arrayable;

/**
 * Encoding to valid json data.
 */
interface JsonEncoderContract
{
    /**
     * Format given data.
     */
    public function format(array|Arrayable $data, bool $booleanAsBinary): array;
}
