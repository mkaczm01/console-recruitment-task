<?php

declare(strict_types=1);

namespace App\Contracts\ExchangeRate;

use App\Contracts\ICurrency;

interface IExchangeRateClient
{
    public function get(ICurrency $source_currency): IExchangeRateResponse;
}
