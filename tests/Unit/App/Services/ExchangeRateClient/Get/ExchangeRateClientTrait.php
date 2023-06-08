<?php

declare(strict_types=1);

namespace Tests\Unit\App\Services\ExchangeRateClient\Get;

use Mockery as m;
use Mockery\MockInterface;
use App\Contracts\ICurrency;
use App\Contracts\Http\IHttpClient;
use App\Contracts\Http\IHttpResponse;

trait ExchangeRateClientTrait
{
    public function mockHttpClientWithValidResponse(): IHttpClient|MockInterface
    {
        $mock = m::mock(IHttpClient::class);

        $response_mock = $this->mockResponseInterface([
            'source' => 'EUR',
            'quotes' => [
                'EURAED' => 3.948514,
                'EURAFN' => 92.628739,
            ],
        ]);

        $mock->allows('get')->once()->andReturn($response_mock);

        return $mock;
    }

    public function mockHttpClientWithNotFoundResponse(): IHttpClient|MockInterface
    {
        $mock = m::mock(IHttpClient::class);

        $response_mock = $this->mockResponseInterface([], 404);

        $mock->allows('get')->once()->andReturn($response_mock);

        return $mock;
    }

    public function mockResponseInterface(
        array $data = [],
        int $http_code = 200,
    ): IHttpResponse|MockInterface {
        $mock = m::mock(IHttpResponse::class);

        $mock->allows('getData')->andReturn($data);
        $mock->allows('getHttpCode')->andReturn($http_code);

        return $mock;
    }

    public function mockICurrency(string $currency_code): ICurrency|MockInterface
    {
        $mock = m::mock(ICurrency::class);

        $mock->allows('getCurrencyCode')->andReturn($currency_code);

        return $mock;
    }
}
