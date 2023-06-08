<?php

declare(strict_types=1);

namespace Tests\Unit\App\Services\MoneyHelper\Round;

trait MoneyHelperTrait
{
    public static function entryDataProvider(): iterable
    {
        yield 'Entry 0.46180' => [
            'entry_data' => 0.46180,
            'expected_data' => 0.47,
        ];

        yield 'Entry 454.545' => [
            'entry_data' => 454.545,
            'expected_data' => 454.55,
        ];

        yield 'Entry 1.46788' => [
            'entry_data' => 1.46788,
            'expected_data' => 1.47,
        ];

        yield 'Entry 1.45555' => [
            'entry_data' => 1.45555,
            'expected_data' => 1.46,
        ];

        yield 'Entry 1.4444' => [
            'entry_data' => 1.4444,
            'expected_data' => 1.45,
        ];

        yield 'Entry 1.44' => [
            'entry_data' => 1.44,
            'expected_data' => 1.44,
        ];

        yield 'Entry 1.45' => [
            'entry_data' => 1.45,
            'expected_data' => 1.45,
        ];

        yield 'Entry 1.46' => [
            'entry_data' => 1.46,
            'expected_data' => 1.46,
        ];

        yield 'Entry 1.0000001' => [
            'entry_data' => 1.0000001,
            'expected_data' => 1.01,
        ];
    }
}
