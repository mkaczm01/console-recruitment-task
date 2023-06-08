<?php

declare(strict_types=1);

namespace App\Contracts;

interface IFileReader
{
    public function read(): array;
}
