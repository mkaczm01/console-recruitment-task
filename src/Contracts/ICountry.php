<?php

declare(strict_types=1);

namespace App\Contracts;

interface ICountry
{
    public function getValue(): string;

    public function isEuropeanCountry(): bool;
}
