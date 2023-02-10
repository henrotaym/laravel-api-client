<?php
namespace Henrotaym\LaravelApiClient\Encoders;

use Henrotaym\LaravelApiClient\Contracts\Encoders\JsonEncoderContract;
use Henrotaym\LaravelApiClient\Encoders\Traits\HasSingleValuesToFormat;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Encoding to valid multipart data.
 */
class JsonEncoder implements JsonEncoderContract
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
        if ($data instanceof JsonResource) return $this->formatResource($data);

        return $this->formatRecursively(
            $data instanceof Arrayable ?
                $data->toArray()
                : $data
        );
    }

    /**
     * format recursively given data.
     * 
     * @param array $data Data to format
     * @param string $namespace Current namespace (should not be given)
     * @param array $formated Current formated representation (should not be given)
     */
    protected function formatRecursively(
        array $data,
        array &$formated = []
    ) {
        foreach ($data as $key => $value):
            $formated[$key] = $value instanceof Arrayable ?
                $value->toArray()
                : (
                    $value instanceof JsonResource
                        ? $this->formatResource($value)
                        : $value
                );

            is_array($formated[$key]) ?
                $this->formatRecursively($formated[$key], $formated[$key])
                : $formated[$key] = $this->formatSingleValue($formated[$key]);
        endforeach;

        return $formated;
    }

    /**
     * Formating given json resource.
     * 
     * @param JsonResource $resource
     * @return array
     */
    protected function formatResource(JsonResource $resource): array
    {
        return json_decode($resource->toJson(), true);
    }
}