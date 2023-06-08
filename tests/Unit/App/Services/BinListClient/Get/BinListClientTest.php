<?php

declare(strict_types=1);

namespace Tests\Unit\App\Services\BinListClient\Get;

use Tests\TestCase;
use App\Services\BinListClient;
use App\Models\ValueObject\BinNumber;

class BinListClientTest extends TestCase
{
    use BinListClientTrait;

    /**
     * @expectation Return valid response for provided bin number
     *
     * @test
     */
    public function get_returnValidResponseForProvidedBinNumber(): void
    {
        // GIVEN
        $http_client_mock = $this->mockHttpClientWithValidResponse();
        $service = new BinListClient($http_client_mock);
        $bin_number = new BinNumber('12341234');

        // WHEN
        $results = $service->get($bin_number);

        // THEN
        $this->assertEquals('12341234', $results->getBinNumber()->getValue());
        $this->assertEquals('PL', $results->getCountry()->getIsoCode());
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

        $service = new BinListClient($http_client_mock);

        $bin_number = new BinNumber('12341234');

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid response from bin list service.');

        // WHEN
        $results = $service->get($bin_number);

        // THEN
    }
}
