<?php

declare(strict_types=1);

namespace App\Models\ExchangeRate;

use App\Contracts\ICurrency;
use App\Contracts\ExchangeRate\IExchangeRateResponse;

readonly class ExchangeRateResponse implements IExchangeRateResponse
{
    public function __construct(
        private ICurrency $source_currency,
        private array $quotes = []
    ) {
    }

    public function getSourceCurrency(): ICurrency
    {
        return $this->source_currency;
    }

    public function getCurrencyRatios(): array
    {
        $array = [];
        foreach ($this->quotes as $key => $value) {
            $key = substr($key, 3);
            $array[$key] = $value;
        }

        return $array;
    }
}
