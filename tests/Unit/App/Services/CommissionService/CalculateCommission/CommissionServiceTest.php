<?php

declare(strict_types=1);

namespace Tests\Unit\App\Services\CommissionService\CalculateCommission;

use Tests\TestCase;
use App\Services\CommissionService;

class CommissionServiceTest extends TestCase
{
    use CommissionServiceTrait;

    /**
     * @expectation Calculate valid commission value
     *
     * @dataProvider entryDataProvider
     *
     * @test
     */
    public function calculateCommission_calculateValidCommissionValue(array $entry_data, array $expected_data): void
    {
        // GIVEN

        $service = new CommissionService();

        $money = $this->mockIMoney($entry_data['value'], $entry_data['currency_code']);
        $country = $this->mockICountry($entry_data['country_code'], $entry_data['is_european_country']);

        // WHEN
        $results = $service->calculateCommission($money, $country);

        // THEN
        $this->assertEquals($expected_data['value'], $results->getValue());
        $this->assertEquals($expected_data['currency_code'], $results->getCurrency()->getCurrencyCode());
    }
}
