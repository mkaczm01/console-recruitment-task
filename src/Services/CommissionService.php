<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\IMoney;
use App\Contracts\ICountry;
use App\Models\ValueObject\Money;
use App\Contracts\ICommissionService;

class CommissionService implements ICommissionService
{
    private const EUROPEAN_COMMISSION_RATE = 0.01;
    private const NON_EUROPEAN_COMMISSION_RATE = 0.02;

    public function calculateCommission(IMoney $money, ICountry $country): IMoney
    {
        $commission_rate = $this->getCommissionRate($country);

        $commission = $money->getValue() * $commission_rate;

        return new Money(
            $commission,
            $money->getCurrency()
        );
    }

    private function getCommissionRate(ICountry $country): float
    {
        if ($country->isEuropeanCountry()) {
            return self::EUROPEAN_COMMISSION_RATE;
        }

        return self::NON_EUROPEAN_COMMISSION_RATE;
    }
}
