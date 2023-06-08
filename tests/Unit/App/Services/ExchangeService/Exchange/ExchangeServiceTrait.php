<?php

declare(strict_types=1);

namespace Tests\Unit\App\Services\ExchangeService\Exchange;

use Mockery as m;
use App\Contracts\IMoney;
use Mockery\MockInterface;
use App\Contracts\ICurrency;

trait ExchangeServiceTrait
{
    public static function entryDataProvider(): iterable
    {
        yield [
            'entry_data' => [
                'value' => 20,
                'currency_code' => 'USD',
            ],
            'expected_data' => [
                'value' => 10,
            ],
        ];

        yield [
            'entry_data' => [
                'value' => 10,
                'currency_code' => 'EUR',
            ],
            'expected_data' => [
                'value' => 10,
            ],
        ];
    }

    public function mockIMoney(float $value, string $currency_code): IMoney|MockInterface
    {
        $mock = m::mock(IMoney::class);

        $mock->allows('getValue')->andReturn($value);
        $mock->allows('getCurrency')->andReturn($this->mockICurrency($currency_code));

        return $mock;
    }

    public function mockICurrency(string $currency_code): ICurrency|MockInterface
    {
        $mock = m::mock(ICurrency::class);

        $mock->allows('getCurrencyCode')->andReturn($currency_code);

        return $mock;
    }
}
