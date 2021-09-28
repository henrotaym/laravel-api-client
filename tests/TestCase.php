<?php
namespace Henrotaym\LaravelApiClient\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Henrotaym\LaravelHelpers\Providers\HelperServiceProvider;
use Henrotaym\LaravelApiClient\Providers\ClientServiceProvider;

class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            ClientServiceProvider::class,
            HelperServiceProvider::class
        ];
    }
}