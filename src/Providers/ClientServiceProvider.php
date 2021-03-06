<?php
namespace Henrotaym\LaravelApiClient\Providers;

use Henrotaym\LaravelApiClient\Client;
use Henrotaym\LaravelApiClient\Request;
use Henrotaym\LaravelApiClient\Contracts\ClientContract;
use Henrotaym\LaravelApiClient\Contracts\RequestContract;
use Henrotaym\LaravelApiClient\Package;
use Henrotaym\LaravelPackageVersioning\Providers\Abstracts\VersionablePackageServiceProvider;

class ClientServiceProvider extends VersionablePackageServiceProvider
{
    public static function getPackageClass(): string
    {
        return Package::class;
    }

    protected function addToRegister(): void
    {
        $this->app->bind(ClientContract::class, Client::class);
        $this->app->bind(RequestContract::class, Request::class);
    }

    protected function addToBoot(): void
    {
        //
    }
}