<?php
namespace Henrotaym\LaravelApiClient\Encoders\Traits;

/** 
 * Formating given single value.
 * 
 * @param mixed $value
 * @return mixed 
 */
trait HasSingleValuesToFormat
{
    protected function formatSingleValue($value)
    {
        if (is_bool($value)):
            return $value ? 1 : 0;
        endif;

        return $value;
    }
}