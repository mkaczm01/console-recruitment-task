<?php

declare(strict_types=1);

namespace Tests\Unit\App\Repositories\CommissionRepository\GetTransactions;

use Mockery as m;
use Mockery\MockInterface;
use App\Contracts\IFileReader;

trait CommissionRepositoryTrait
{
    public function mockFileReader(array $data): IFileReader|MockInterface
    {
        $mock = m::mock(IFileReader::class);

        $mock->allows('read')->andReturn($data);

        return $mock;
    }
}
