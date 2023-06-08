<?php

declare(strict_types=1);

namespace App\Contracts\BinList;

use App\Models\ValueObject\Country;
use App\Models\ValueObject\BinNumber;

interface IBinListService
{
    public function getCountry(BinNumber $bin_number): Country;
}
