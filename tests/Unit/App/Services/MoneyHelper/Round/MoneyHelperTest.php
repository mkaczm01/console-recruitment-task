<?php

declare(strict_types=1);

namespace Tests\Unit\App\Services\MoneyHelper\Round;

use Tests\TestCase;
use App\Services\MoneyHelper;

class MoneyHelperTest extends TestCase
{
    use MoneyHelperTrait;

    /**
     * @expectation Return valid rounded entry value
     *
     * @dataProvider entryDataProvider
     *
     * @test
     */
    public function round_returnValidRoundedEntryValue(float $entry_data, float $expected_data): void
    {
        // GIVEN

        // WHEN
        $results = MoneyHelper::round($entry_data);

        // THEN
        $this->assertEquals($expected_data, $results);
    }
}
