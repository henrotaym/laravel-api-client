<?php
namespace Henrotaym\LaravelApiClient\Contracts;

/**
 * Encoding to valid multipart data.
 */
interface MultipartEncoderContract
{
    /**
     * Flatten given data.
     * 
     * @param array $data
     * @return array
     */
    public function flatten(array $data): array;
}