<?php

declare(strict_types=1);

namespace App\Models\BinList;

use App\Contracts\BinList\ICountryResponse;

readonly class CountryResponse implements ICountryResponse
{
    public function __construct(
        private string $iso_code
    ) {
    }

    public function getIsoCode(): string
    {
        return $this->iso_code;
    }
}
