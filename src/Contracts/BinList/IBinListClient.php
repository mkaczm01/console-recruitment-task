<?php

declare(strict_types=1);

namespace App\Contracts\BinList;

use App\Contracts\IBinNumber;

interface IBinListClient
{
    public function get(IBinNumber $bin_number): IBinListResponse;
}
