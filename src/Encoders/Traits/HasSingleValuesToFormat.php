<?php

namespace Henrotaym\LaravelApiClient\Encoders\Traits;

/**
 * Formating given single value.
 *
 * @param  mixed  $value
 * @return mixed
 */
trait HasSingleValuesToFormat
{
    protected function formatSingleValue($value, bool $booleanAsBinary)
    {
        if (is_bool($value) && $booleanAsBinary) {
            return $value ? 1 : 0;
        }

        return $value;
    }
}
