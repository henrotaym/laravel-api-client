<?php
namespace Henrotaym\LaravelApiClient\Tests\Unit;

use Henrotaym\LaravelApiClient\Contracts\ClientContract;
use Henrotaym\LaravelApiClient\Contracts\Encoders\JsonEncoderContract;
use Henrotaym\LaravelApiClient\Contracts\RequestContract;
use Henrotaym\LaravelApiClient\Tests\TestCase;
use Henrotaym\LaravelPackageVersioning\Testing\Traits\InstallPackageTest;

class ExampleTest extends TestCase
{
    use InstallPackageTest;

    /**
     * @test
     */
    public function returning_true()
    {
        /** @var ClientContract */
        $client = $this->app->make(ClientContract::class);
        /** @var RequestContract */
        $request = $this->app->make(RequestContract::class);

        $request->addData([
            'hello' => "coucou",
            'salam' => [
                [
                    'resource' => "string",
                    'name' => "testastos"
                ]
            ]
        ])
        ->setVerb('post')
        ->setIsMultipart(true)
        ->setUrl('https://laramara.com');

        $response = $client->try($request, "it failed.");

        if ($response->failed()):
            dd($response->error()->context());
        endif;


        $this->assertTrue(true);
    }
}