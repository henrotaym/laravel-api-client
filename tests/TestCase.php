<?php
namespace Henrotaym\LaravelApiClient\Tests;

use Henrotaym\LaravelApiClient\Package;
use Henrotaym\LaravelApiClient\Providers\ClientServiceProvider;
use Henrotaym\LaravelPackageVersioning\Testing\VersionablePackageTestCase;

class TestCase extends VersionablePackageTestCase
{
    public static function getPackageClass(): string
    {
        return Package::class;
    }
    
    public function getServiceProviders(): array
    {
        return [
            ClientServiceProvider::class
        ];
    }
}