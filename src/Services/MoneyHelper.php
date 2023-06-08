<?php

declare(strict_types=1);

namespace App\Services;

class MoneyHelper
{
    public static function round(float $value, float $precision = 0.01): float
    {
        return \round(
            \ceil($value / $precision) * $precision,
            2
        );
    }
}
