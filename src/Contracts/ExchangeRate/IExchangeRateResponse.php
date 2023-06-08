<?php

declare(strict_types=1);

namespace App\Contracts\ExchangeRate;

use App\Contracts\ICurrency;

interface IExchangeRateResponse
{
    public function getSourceCurrency(): ICurrency;

    public function getCurrencyRatios(): array;
}
