<?php

namespace Henrotaym\LaravelApiClient\Contracts\Encoders;

use Henrotaym\LaravelApiClient\Contracts\RequestContract;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Client\PendingRequest;

/**
 * Encoding to valid multipart data.
 */
interface MultipartEncoderContract
{
    /**
     * Format given data.
     *
     * @param  RequestContract  $request  Related request (We might need it to attach files)
     */
    public function format(array|Arrayable $data, PendingRequest &$request, bool $booleanAsBinary): array;
}
