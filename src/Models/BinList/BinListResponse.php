<?php

declare(strict_types=1);

namespace App\Models\BinList;

use App\Contracts\IBinNumber;
use App\Contracts\BinList\IBinListResponse;
use App\Contracts\BinList\ICountryResponse;

readonly class BinListResponse implements IBinListResponse
{
    public function __construct(
        private IBinNumber $bin_number,
        private CountryResponse $country
    ) {
    }

    public function getBinNumber(): IBinNumber
    {
        return $this->bin_number;
    }

    public function getCountry(): ICountryResponse
    {
        return $this->country;
    }
}
