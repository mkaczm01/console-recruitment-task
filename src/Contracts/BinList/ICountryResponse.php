<?php

declare(strict_types=1);

namespace App\Contracts\BinList;

interface ICountryResponse
{
    public function getIsoCode(): string;
}
