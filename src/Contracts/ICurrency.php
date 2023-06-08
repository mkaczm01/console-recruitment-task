<?php

declare(strict_types=1);

namespace App\Contracts;

interface ICurrency
{
    public function getCurrencyCode(): string;
}
