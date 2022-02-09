<?php
namespace Henrotaym\LaravelApiClient;

use Henrotaym\LaravelPackageVersioning\Services\Versioning\VersionablePackage;

class Package extends VersionablePackage
{
    public static function prefix(): string
    {
        return "laravel_api_client";
    }
}