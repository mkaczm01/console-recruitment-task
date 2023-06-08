<?php

declare(strict_types=1);

namespace App\Models\ValueObject;

use App\Contracts\ICurrency;

readonly class Currency implements ICurrency
{
    private const AVAILABLE = [
        'EUR',
        'USD',
        'JPY',
        'GBP',
    ];

    public function __construct(
        private string $currency_code
    ) {
        if (!in_array($this->currency_code, self::AVAILABLE, true)) {
            throw new \InvalidArgumentException('Invalid currency code.');
        }
    }

    public function getCurrencyCode(): string
    {
        return $this->currency_code;
    }
}
