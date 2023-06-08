<?php

declare(strict_types=1);

namespace App\Contracts\Repositories;

interface ICommissionRepository
{
    public function getTransactions(): array;
}
