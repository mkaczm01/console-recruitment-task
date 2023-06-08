<?php

declare(strict_types=1);

namespace App\Contracts;

interface IExchangeService
{
    public function setSourceCurrency(ICurrency $source_currency): self;

    public function setCurrencyRatios(array $currency_ratios): self;

    public function exchange(IMoney $from, ICurrency $to): IMoney;
}
