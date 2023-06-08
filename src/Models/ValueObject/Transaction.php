<?php

declare(strict_types=1);

namespace App\Models\ValueObject;

use App\Contracts\IMoney;
use App\Contracts\IBinNumber;
use App\Contracts\ITransaction;

readonly class Transaction implements ITransaction
{
    public function __construct(
        private BinNumber $bin_number,
        private Money $money
    ) {
    }

    public function getBinNumber(): IBinNumber
    {
        return $this->bin_number;
    }

    public function getMoney(): IMoney
    {
        return $this->money;
    }
}
