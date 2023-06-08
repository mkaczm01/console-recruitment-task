<?php

declare(strict_types=1);

namespace Tests\Unit\App\Repositories\CommissionRepository\GetTransactions;

use Tests\TestCase;
use App\Repositories\Json\CommissionRepository;

class CommissionRepositoryTest extends TestCase
{
    use CommissionRepositoryTrait;

    /**
     * @expectation Return two Transaction objects in array
     *
     * @test
     */
    public function getTransactions_returnTwoTransactionObjectsInArray(): void
    {
        // GIVEN
        $entry_data = [
            [
                'bin' => '45717360',
                'amount' => '100.00',
                'currency' => 'EUR',
            ],
            [
                'bin' => '516793',
                'amount' => '50.00',
                'currency' => 'USD',
            ],
        ];
        $file_reader_mock = $this->mockFileReader($entry_data);
        $repository = new CommissionRepository($file_reader_mock);

        // WHEN
        $results = $repository->getTransactions();

        // THEN
        $this->assertEquals('45717360', $results[0]->getBinNumber()->getValue());
        $this->assertEquals(100.0, $results[0]->getMoney()->getValue());
        $this->assertEquals('EUR', $results[0]->getMoney()->getCurrency()->getCurrencyCode());

        $this->assertEquals('516793', $results[1]->getBinNumber()->getValue());
        $this->assertEquals(50.0, $results[1]->getMoney()->getValue());
        $this->assertEquals('USD', $results[1]->getMoney()->getCurrency()->getCurrencyCode());
    }

    /**
     * @expectation Return empty array
     *
     * @test
     */
    public function getTransactions_returnEmptyArray(): void
    {
        // GIVEN
        $entry_data = [];
        $file_reader_mock = $this->mockFileReader($entry_data);
        $repository = new CommissionRepository($file_reader_mock);

        // WHEN
        $results = $repository->getTransactions();

        // THEN
        $this->assertEmpty($results);
    }
}
