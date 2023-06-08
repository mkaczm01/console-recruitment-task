<?php

declare(strict_types=1);

namespace App\Repositories\Json;

use App\Contracts\IFileReader;
use App\Contracts\ITransaction;
use App\Models\ValueObject\Money;
use App\Models\ValueObject\Currency;
use App\Models\ValueObject\BinNumber;
use App\Models\ValueObject\Transaction;
use App\Contracts\Repositories\ICommissionRepository;

readonly class CommissionRepository implements ICommissionRepository
{
    public function __construct(
        private IFileReader $file_reader
    ) {
    }

    /** @return ITransaction[] */
    public function getTransactions(): array
    {
        $transactions = [];

        $lines = $this->file_reader->read();

        foreach ($lines as $line) {
            $money = new Money(
                (float) $line['amount'],
                new Currency($line['currency'])
            );

            $transactions[] = new Transaction(
                new BinNumber($line['bin']),
                $money
            );
        }

        return $transactions;
    }
}
