<?php

declare(strict_types=1);

namespace Tests\Unit\App\Services\ExchangeRateClient\Get;

use Tests\TestCase;
use App\Models\ValueObject\Currency;
use App\Services\ExchangeRateClient;

class ExchangeRateClientTest extends TestCase
{
    use ExchangeRateClientTrait;

    /**
     * @expectation Return valid response for source currency
     *
     * @test
     */
    public function get_returnValidResponseForSourceCurrency(): void
    {
        // GIVEN
        $http_client_mock = $this->mockHttpClientWithValidResponse();
        $api_key = 'test';

        $service = new ExchangeRateClient($http_client_mock, $api_key);

        $source_currency = $this->mockICurrency('EUR');

        // WHEN
        $results = $service->get($source_currency);

        // THEN
        $quotes = $results->getCurrencyRatios();
        $this->assertCount(2, $quotes);
        $this->assertEquals('EUR', $results->getSourceCurrency()->getCurrencyCode());
        $this->assertEquals(3.948514, $quotes['AED']);
        $this->assertEquals(92.628739, $quotes['AFN']);
    }

    /**
     * @expectation Exception thrown during getting response
     *
     * @test
     */
    public function get_exceptionThrownDuringGettingResponse(): void
    {
        // GIVEN
        $http_client_mock = $this->mockHttpClientWithNotFoundResponse();
        $api_key = 'test';

        $service = new ExchangeRateClient($http_client_mock, $api_key);

        $source_currency = $this->mockICurrency('EUR');

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid response from exchange service.');

        // WHEN
        $results = $service->get($source_currency);

        // THEN
    }

    /**
     * @expectation Exception thrown because no API key provided
     *
     * @test
     */
    public function get_exceptionThrownBecauseNoApiKeyProvided(): void
    {
        // GIVEN
        $http_client_mock = $this->mockHttpClientWithNotFoundResponse();

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('No API key for apilayer provided.');

        // WHEN
        $service = new ExchangeRateClient($http_client_mock);

        // THEN
    }
}
