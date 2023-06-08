<?php

declare(strict_types=1);

namespace App\Contracts\BinList;

use App\Contracts\IBinNumber;

interface IBinListResponse
{
    public function getBinNumber(): IBinNumber;

    public function getCountry(): ICountryResponse;
}
