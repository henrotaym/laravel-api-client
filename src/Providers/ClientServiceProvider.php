<?php
namespace Henrotaym\LaravelApiClient\Providers;

use Henrotaym\LaravelApiClient\Client;
use Henrotaym\LaravelApiClient\Request;
use Illuminate\Support\ServiceProvider;
use Henrotaym\LaravelApiClient\Contracts\ClientContract;
use Henrotaym\LaravelApiClient\Contracts\RequestContract;

class ClientServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(ClientContract::class, Client::class);
        $this->app->bind(RequestContract::class, Request::class);
    }
}