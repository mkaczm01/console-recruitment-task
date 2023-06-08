<?php

declare(strict_types=1);

namespace Tests\Unit\App\Services\ExchangeService\Exchange;

use Tests\TestCase;
use App\Services\ExchangeService;

class ExchangeServiceTest extends TestCase
{
    use ExchangeServiceTrait;

    /**
     * @expectation Return valid amount and currency after exchange
     *
     * @dataProvider entryDataProvider
     *
     * @test
     */
    public function exchange_returnValidAmountAndCurrencyAfterExchange(array $entry_data, array $expected_data): void
    {
        // GIVEN
        $from = $this->mockIMoney($entry_data['value'], $entry_data['currency_code']);
        $currency = $this->mockICurrency('EUR');
        $currency_ratios = [
            'USD' => 2,
            'PLN' => 4,
        ];

        $service = new ExchangeService();
        $service
            ->setSourceCurrency($currency)
            ->setCurrencyRatios($currency_ratios)
        ;

        // WHEN
        $results = $service->exchange($from, $currency);

        // THEN
        $this->assertEquals($expected_data['value'], $results->getValue());
        $this->assertEquals('EUR', $results->getCurrency()->getCurrencyCode());
    }

    /**
     * @expectation Throw error that can not convert into currency which is different from source currency
     *
     * @test
     */
    public function exchange_throwErrorThatCanNotConvertIntoCurrencyWhichIsDifferentFromSourceCurrency(): void
    {
        // GIVEN
        $from = $this->mockIMoney(10, 'EUR');

        $service = new ExchangeService();

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Can not convert from this currency.');

        // WHEN
        $results = $service->exchange($from, $this->mockICurrency('PLN'));

        // THEN
    }

    /**
     * @expectation Throw error that can not convert into currency which is not available in currency ratio array
     *
     * @test
     */
    public function exchange_throwErrorThatCanNotConvertIntoCurrencyWhichIsNotAvailableInCurrencyRatioArray(): void
    {
        // GIVEN
        $from = $this->mockIMoney(10, 'JPY');
        $currency = $this->mockICurrency('EUR');

        $service = new ExchangeService();
        $service
            ->setSourceCurrency($currency)
        ;

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Can not convert from this currency.');

        // WHEN
        $results = $service->exchange($from, $currency);

        // THEN
    }

    /**
     * @expectation Throw error that can not convert into currency which has zero value in currency ratio array
     *
     * @test
     */
    public function exchange_throwErrorThatCanNotConvertIntoCurrencyWhichHasZeroValueInCurrencyRatioArray(): void
    {
        // GIVEN
        $from = $this->mockIMoney(10, 'JPY');
        $currency = $this->mockICurrency('EUR');

        $currency_ratio = [
            'JPY' => 0,
        ];

        $service = new ExchangeService();
        $service
            ->setSourceCurrency($currency)
            ->setCurrencyRatios($currency_ratio)
        ;

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid ratio for currency.');

        // WHEN
        $results = $service->exchange($from, $currency);

        // THEN
    }
}
