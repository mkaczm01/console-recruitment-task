<?php

declare(strict_types=1);

namespace App\Contracts;

interface ICommissionService
{
    public function calculateCommission(IMoney $money, ICountry $country): IMoney;
}
