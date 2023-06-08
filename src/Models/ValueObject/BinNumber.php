<?php

declare(strict_types=1);

namespace App\Models\ValueObject;

use App\Contracts\IBinNumber;

readonly class BinNumber implements IBinNumber
{
    public function __construct(
        private string $bin_number
    ) {
    }

    public function getValue(): string
    {
        return $this->bin_number;
    }
}
