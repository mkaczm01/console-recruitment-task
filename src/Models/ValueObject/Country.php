<?php

declare(strict_types=1);

namespace App\Models\ValueObject;

use App\Contracts\ICountry;

readonly class Country implements ICountry
{
    private const EUROPEAN_COUNTRIES = [
        'AT',
        'BE',
        'BG',
        'CY',
        'CZ',
        'DE',
        'DK',
        'EE',
        'ES',
        'FI',
        'FR',
        'GR',
        'HR',
        'HU',
        'IE',
        'IT',
        'LT',
        'LU',
        'LV',
        'MT',
        'NL',
        'PO',
        'PT',
        'RO',
        'SE',
        'SI',
        'SK',
    ];

    protected string $country_code;

    public function __construct(
        string $country_code
    ) {
        $this->country_code = \mb_strtoupper($country_code);
    }

    public function getValue(): string
    {
        return $this->country_code;
    }

    public function isEuropeanCountry(): bool
    {
        return \in_array($this->country_code, self::EUROPEAN_COUNTRIES, true);
    }
}
