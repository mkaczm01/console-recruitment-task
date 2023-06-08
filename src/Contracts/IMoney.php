<?php

declare(strict_types=1);

namespace App\Contracts;

interface IMoney
{
    public function getValue(): float;

    public function getCurrency(): ICurrency;
}
