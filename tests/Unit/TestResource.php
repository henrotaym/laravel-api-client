<?php

namespace Henrotaym\LaravelApiClient\Tests\Unit;

use Illuminate\Http\Resources\Json\JsonResource;

class TestResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'hello' => 'world',
        ];
    }
}
