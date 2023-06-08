<?php

declare(strict_types=1);

namespace Tests\Unit\App\Services\CommissionService\CalculateCommission;

use Mockery as m;
use App\Contracts\IMoney;
use Mockery\MockInterface;
use App\Contracts\ICountry;
use App\Contracts\ICurrency;

trait CommissionServiceTrait
{
    public static function entryDataProvider(): iterable
    {
        yield [
            'entry_data' => [
                'value' => 100,
                'currency_code' => 'EUR',
                'country_code' => 'PL',
                'is_european_country' => true,
            ],
            'expected_data' => [
                'value' => 1,
                'currency_code' => 'EUR',
            ],
        ];

        yield [
            'entry_data' => [
                'value' => 50,
                'currency_code' => 'EUR',
                'country_code' => 'UK',
                'is_european_country' => true,
            ],
            'expected_data' => [
                'value' => 0.5,
                'currency_code' => 'EUR',
            ],
        ];

        yield [
            'entry_data' => [
                'value' => 100,
                'currency_code' => 'EUR',
                'country_code' => 'JP',
                'is_european_country' => false,
            ],
            'expected_data' => [
                'value' => 2,
                'currency_code' => 'EUR',
            ],
        ];
    }

    public function mockICountry(string $country_code, bool $is_european_country): ICountry|MockInterface
    {
        $mock = m::mock(ICountry::class);

        $mock->allows('getValue')->andReturn($country_code);
        $mock->allows('isEuropeanCountry')->andReturn($is_european_country);

        return $mock;
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
