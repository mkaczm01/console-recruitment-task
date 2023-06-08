<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\IFileReader;

class JsonFileReader implements IFileReader
{
    protected string $file;
    protected mixed $handle;

    public function __construct(
        string $file
    ) {
        $this->file = $file;

        $this->handle = \fopen($this->file, 'rb');
        if (!$this->handle) {
            throw new \RuntimeException('Unable to read file');
        }
    }

    /** @return array<int, array> $currency_ratios */
    public function read(): array
    {
        $objects = [];

        while (($line = \fgets($this->handle)) !== false) {
            $objects[] = \json_decode($line, true, 512, JSON_THROW_ON_ERROR);
        }

        \fclose($this->handle);

        return $objects;
    }
}
