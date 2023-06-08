<?php

declare(strict_types=1);

namespace Tests\Unit\App\Commands\CommissionsCommand\Execute;

use Mockery as m;
use Mockery\MockInterface;
use App\Contracts\ICurrency;
use App\Contracts\IBinNumber;
use App\Services\BinListClient;
use App\Services\ExchangeRateClient;
use App\Models\ValueObject\BinNumber;
use App\Contracts\BinList\IBinListResponse;
use App\Contracts\BinList\ICountryResponse;
use App\Contracts\ExchangeRate\IExchangeRateResponse;

trait CommissionsCommandTrait
{
    public function mockBinListClient(): BinListClient|MockInterface
    {
        $mock = m::mock(BinListClient::class);

        $bin_number = new BinNumber('45717360');
        $mock->allows('get')->with(m::on(function (BinNumber $bin_number) {
            return '45717360' === $bin_number->getValue();
        }))->andReturn($this->mockIBinListResponse($bin_number, 'DK'));

        $bin_number = new BinNumber('516793');
        $mock->allows('get')->with(m::on(function (BinNumber $bin_number) {
            return '516793' === $bin_number->getValue();
        }))->andReturn($this->mockIBinListResponse($bin_number, 'LT'));

        $bin_number = new BinNumber('45417360');
        $mock->allows('get')->with(m::on(function (BinNumber $bin_number) {
            return '45417360' === $bin_number->getValue();
        }))->andReturn($this->mockIBinListResponse($bin_number, 'JP'));

        $bin_number = new BinNumber('41417360');
        $mock->allows('get')->with(m::on(function (BinNumber $bin_number) {
            return '41417360' === $bin_number->getValue();
        }))->andReturn($this->mockIBinListResponse($bin_number, 'US'));

        $bin_number = new BinNumber('4745030');
        $mock->allows('get')->with(m::on(function (BinNumber $bin_number) {
            return '4745030' === $bin_number->getValue();
        }))->andReturn($this->mockIBinListResponse($bin_number, 'GB'));

        return $mock;
    }

    public function mockExchangeRateClient(): ExchangeRateClient|MockInterface
    {
        $mock = m::mock(ExchangeRateClient::class);

        $mock->allows('get')->andReturn($this->mockIExchangeRateResponse());

        return $mock;
    }

    public function mockIExchangeRateResponse(): IExchangeRateResponse|MockInterface
    {
        $mock = m::mock(IExchangeRateResponse::class);

        $mock->allows('getSourceCurrency')->andReturn($this->mockICurrency('EUR'));
        $mock->allows('getCurrencyRatios')->andReturn([
            'USD' => 1.075003,
            'JPY' => 149.894188,
            'GBP' => 0.861089,
        ]);

        return $mock;
    }

    public function mockICurrency(string $currency_code): ICurrency|MockInterface
    {
        $mock = m::mock(ICurrency::class);

        $mock->allows('getCurrencyCode')->andReturn($currency_code);

        return $mock;
    }

    public function mockIBinListResponse(IBinNumber $bin_number, string $country_iso_code): IBinListResponse|MockInterface
    {
        $mock = m::mock(IBinListResponse::class);

        $mock->allows('getBinNumber')->andReturn($bin_number);
        $mock->allows('getCountry')->andReturn($this->mockICountryResponse($country_iso_code));

        return $mock;
    }

    public function mockICountryResponse(string $country_iso_code): ICountryResponse|MockInterface
    {
        $mock = m::mock(ICountryResponse::class);

        $mock->allows('getIsoCode')->andReturn($country_iso_code);

        return $mock;
    }
}
