<?php

declare(strict_types=1);

namespace Tests\Unit\App\Commands\CommissionsCommand\Execute;

use Tests\TestCase;
use App\Services\BinListClient;
use App\Commands\CommissionsCommand;
use App\Services\ExchangeRateClient;
use Symfony\Component\Console\Tester\CommandTester;

class CommissionsCommandTest extends TestCase
{
    use CommissionsCommandTrait;

    protected CommandTester $command_tester;

    /**
     * @expectation Return valid commission data
     *
     * @test
     */
    public function execute_returnValidCommissionData(): void
    {
        // GIVEN
        $bin_list_client_mock = $this->mockBinListClient();
        $this->container->removeDefinition(BinListClient::class);
        $this->container->set(BinListClient::class, $bin_list_client_mock);

        $exchange_rate_client_mock = $this->mockExchangeRateClient();
        $this->container->removeDefinition(ExchangeRateClient::class);
        $this->container->set(ExchangeRateClient::class, $exchange_rate_client_mock);

        $command = $this->container->get(CommissionsCommand::class);
        $this->command_tester = new CommandTester($command);

        // WHEN
        $results = $this->command_tester->execute(['file' => __DIR__.'/input.txt']);

        // THEN
        $this->assertEquals(0, $results);
        $this->assertEquals("1\n0.47\n1.34\n2.42\n46.46\n", $this->command_tester->getDisplay(true));
    }
}
