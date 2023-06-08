<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\IMoney;
use App\Contracts\ICurrency;
use App\Models\ValueObject\Money;
use App\Contracts\IExchangeService;
use App\Models\ValueObject\Currency;

class ExchangeService implements IExchangeService
{
    protected ICurrency $source_currency;
    protected array $currency_ratios;

    public function __construct()
    {
        $this->source_currency = new Currency('EUR');
        $this->currency_ratios = [];
    }

    public function setSourceCurrency(ICurrency $source_currency): self
    {
        $this->source_currency = $source_currency;

        return $this;
    }

    public function setCurrencyRatios(array $currency_ratios): self
    {
        $this->currency_ratios = $currency_ratios;

        return $this;
    }

    public function exchange(IMoney $from, ICurrency $to): IMoney
    {
        if ($to->getCurrencyCode() !== $this->source_currency->getCurrencyCode()) {
            throw new \Exception('Can not convert from this currency.');
        }

        $ratio = $this->findRatio($from->getCurrency()->getCurrencyCode());

        return new Money(
            $from->getValue() / $ratio,
            $to
        );
    }

    private function findRatio(string $currency_iso_code): float
    {
        if ($currency_iso_code === $this->source_currency->getCurrencyCode()) {
            return 1.0;
        }

        if (!array_key_exists($currency_iso_code, $this->currency_ratios)) {
            throw new \Exception('Can not convert from this currency.');
        }

        $ratio = $this->currency_ratios[$currency_iso_code];
        if (0 === $ratio) {
            throw new \Exception('Invalid ratio for currency.');
        }

        return $ratio;
    }
}
