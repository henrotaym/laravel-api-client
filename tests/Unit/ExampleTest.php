<?php
namespace Henrotaym\LaravelApiClient\Tests\Unit;

use Henrotaym\LaravelApiClient\Contracts\ClientContract;
use Henrotaym\LaravelApiClient\Contracts\Encoders\JsonEncoderContract;
use Henrotaym\LaravelApiClient\Contracts\RequestContract;
use Henrotaym\LaravelApiClient\Encoders\JsonEncoder;
use Henrotaym\LaravelApiClient\Request;
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

        $this->assertTrue(is_array($response->error()->context()));
    }

    public function test_that_formating_resource()
    {
        $data = ['test' => new TestResource("test")];
        $formater = new JsonEncoder();

        $this->assertEquals(
            ['test' => ['hello' => 'world']],
            $formater->format($data)
        );
    }

    public function test_that_formating_arrayable()
    {
        $data = ['test' => new TestArrayable()];
        $formater = new JsonEncoder();

        $this->assertEquals(
            ['test' => ['hello' => 'world']],
            $formater->format($data)
        );
    }

    public function test_that_setting_certificate()
    {
        $path = "test/certificate.pem";
        $passphrase = "password";
        $request = new Request();
        $request->setCertificate($path, $passphrase);

        $this->assertEquals(
            [
                "cert" => [$path, $passphrase]
            ],
            $request->getOptions()->toArray()
        );
    }

    public function test_that_setting_key()
    {
        $path = "test/private_key.pem";
        $request = new Request();
        $request->setKey($path);

        $this->assertEquals(
            [
                "ssl_key" => $path
            ],
            $request->getOptions()->toArray()
        );
    }

    public function test_that_getting_query()
    {
        $query = ["hello" => "nice"];
        $request = new Request();

        $request->addQuery($query);

        $this->assertEquals(
            $query,
            $request->query()->all()
        );
    }

    public function test_that_getting_query_less_url()
    {
        $query = ["hello" => "nice"];
        $url = "/test/nice";
        $request = new Request();

        $request->setUrl($url)
            ->addQuery($query);

        $this->assertEquals(
            $url,
            $request->queryLessUrl()
        );
    }

    public function test_that_getting_query_less_url_if_url_contains_parameters()
    {
        $query = ["hello" => "nice"];
        $url = "/test/nice";
        $request = new Request();

        $request->setUrl("$url?test=false")
            ->addQuery($query);

        $this->assertEquals(
            $url,
            $request->queryLessUrl()
        );
    }
}