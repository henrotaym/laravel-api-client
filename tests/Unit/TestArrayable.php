<?php
namespace Henrotaym\LaravelApiClient\Tests\Unit;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;

class TestArrayable implements Arrayable
{
    public function toArray()
    {
        return [
            "hello" => "world"
        ];
    }
}