<?php

declare(strict_types=1);

namespace App\Models\ValueObject;

use App\Contracts\IMoney;
use App\Contracts\ICurrency;

readonly class Money implements IMoney
{
    public function __construct(
        private float $value,
        private ICurrency $currency
    ) {
        if ($this->value < 0) {
            throw new \InvalidArgumentException('Money value can not be less than 0');
        }
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function getCurrency(): ICurrency
    {
        return $this->currency;
    }
}
