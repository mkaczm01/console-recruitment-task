<?php

declare(strict_types=1);

namespace App\Contracts;

interface ITransaction
{
    public function getBinNumber(): IBinNumber;

    public function getMoney(): IMoney;
}
