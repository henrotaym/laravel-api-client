<?php

namespace Henrotaym\LaravelApiClient\Tests\Unit;

use Illuminate\Contracts\Support\Arrayable;

class TestArrayable implements Arrayable
{
    public function toArray()
    {
        return [
            'hello' => 'world',
        ];
    }
}
