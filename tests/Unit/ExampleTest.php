<?php

namespace Henrotaym\LaravelApiClient\Tests\Unit;

use Henrotaym\LaravelApiClient\Contracts\ClientContract;
use Henrotaym\LaravelApiClient\Contracts\RequestContract;
use Henrotaym\LaravelApiClient\Encoders\JsonEncoder;
use Henrotaym\LaravelApiClient\Request;
use Henrotaym\LaravelApiClient\Tests\TestCase;
use Henrotaym\LaravelPackageVersioning\Testing\Traits\InstallPackageTest;
use PHPUnit\Framework\Attributes\Test;

class ExampleTest extends TestCase
{
    use InstallPackageTest;

    #[Test]
    public function returning_true(): void
    {
        /** @var ClientContract */
        $client = $this->app->make(ClientContract::class);
        /** @var RequestContract */
        $request = $this->app->make(RequestContract::class);

        $request->addData([
            'hello' => 'coucou',
            'salam' => [
                [
                    'resource' => 'string',
                    'name' => 'testastos',
                    'bool' => true,
                ],
            ],
        ])
            ->setVerb('post')
            ->setIsMultipart(true)
            ->setUrl('https://laramara.com')
            ->setBooleanAsBinary(false);

        $response = $client->try($request, 'it failed.');

        $this->assertTrue(is_array($response->error()->context()));
    }

    public function test_that_formating_resource(): void
    {
        $data = ['test' => new TestResource('test')];
        $formater = new JsonEncoder;

        $this->assertEquals(
            ['test' => ['hello' => 'world']],
            $formater->format($data, true)
        );
    }

    public function test_that_formating_arrayable(): void
    {
        $data = ['test' => new TestArrayable];
        $formater = new JsonEncoder;

        $this->assertEquals(
            ['test' => ['hello' => 'world']],
            $formater->format($data, true)
        );
    }

    public function test_that_formating_boolean_as_binary(): void
    {
        $data = ['test' => true];
        $formater = new JsonEncoder;

        $this->assertEquals(
            ['test' => 1],
            $formater->format($data, true)
        );
    }

    public function test_that_not_formating_boolean_as_binary(): void
    {
        $data = ['test' => true];
        $formater = new JsonEncoder;

        $this->assertEquals(
            $data,
            $formater->format($data, false)
        );
    }

    public function test_that_setting_certificate(): void
    {
        $path = 'test/certificate.pem';
        $passphrase = 'password';
        $request = new Request;
        $request->setCertificate($path, $passphrase);

        $this->assertEquals(
            [
                'cert' => [$path, $passphrase],
            ],
            $request->getOptions()->toArray()
        );
    }

    public function test_that_setting_key(): void
    {
        $path = 'test/private_key.pem';
        $request = new Request;
        $request->setKey($path);

        $this->assertEquals(
            [
                'ssl_key' => $path,
            ],
            $request->getOptions()->toArray()
        );
    }

    public function test_that_getting_query(): void
    {
        $query = ['hello' => 'nice'];
        $request = new Request;

        $request->addQuery($query);

        $this->assertEquals(
            $query,
            $request->query()->all()
        );
    }

    public function test_that_getting_query_less_url(): void
    {
        $query = ['hello' => 'nice'];
        $url = '/test/nice';
        $request = new Request;

        $request->setUrl($url)
            ->addQuery($query);

        $this->assertEquals(
            $url,
            $request->queryLessUrl()
        );
    }

    public function test_that_getting_query_less_url_if_url_contains_parameters(): void
    {
        $query = ['hello' => 'nice'];
        $url = '/test/nice';
        $request = new Request;

        $request->setUrl("$url?test=false")
            ->addQuery($query);

        $this->assertEquals(
            $url,
            $request->queryLessUrl()
        );
    }
}
