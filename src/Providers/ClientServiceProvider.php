<?php

namespace Henrotaym\LaravelApiClient\Providers;

use Henrotaym\LaravelApiClient\Client;
use Henrotaym\LaravelApiClient\Contracts\ClientContract;
use Henrotaym\LaravelApiClient\Contracts\Encoders\JsonEncoderContract;
use Henrotaym\LaravelApiClient\Contracts\Encoders\MultipartEncoderContract;
use Henrotaym\LaravelApiClient\Contracts\RequestContract;
use Henrotaym\LaravelApiClient\Encoders\JsonEncoder;
use Henrotaym\LaravelApiClient\Encoders\MultipartEncoder;
use Henrotaym\LaravelApiClient\Package;
use Henrotaym\LaravelApiClient\Request;
use Henrotaym\LaravelPackageVersioning\Providers\Abstracts\VersionablePackageServiceProvider;

class ClientServiceProvider extends VersionablePackageServiceProvider
{
    public static function getPackageClass(): string
    {
        return Package::class;
    }

    protected function addToRegister(): void
    {
        $this->app->bind(MultipartEncoderContract::class, MultipartEncoder::class);
        $this->app->bind(JsonEncoderContract::class, JsonEncoder::class);
        $this->app->bind(ClientContract::class, Client::class);
        $this->app->bind(RequestContract::class, Request::class);
    }

    protected function addToBoot(): void
    {
        //
    }
}
