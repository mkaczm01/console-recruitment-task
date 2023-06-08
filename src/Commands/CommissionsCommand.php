<?php

declare(strict_types=1);

namespace App\Commands;

use App\Services\MoneyHelper;
use App\Services\JsonFileReader;
use App\Contracts\IExchangeService;
use App\Models\ValueObject\Country;
use App\Models\ValueObject\Currency;
use App\Contracts\ICommissionService;
use App\Contracts\BinList\IBinListClient;
use Symfony\Component\Console\Command\Command;
use App\Repositories\Json\CommissionRepository;
use Symfony\Component\Console\Input\InputArgument;
use App\Contracts\ExchangeRate\IExchangeRateClient;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CommissionsCommand extends Command
{
    protected static $defaultName = 'Commission command.';
    protected IBinListClient $bin_list_client;
    protected IExchangeRateClient $exchange_rate_client;
    protected IExchangeService $exchange_service;
    protected ICommissionService $commission_service;

    public function __construct(
        IBinListClient $bin_list_client,
        IExchangeRateClient $exchange_rate_client,
        IExchangeService $exchange_service,
        ICommissionService $commission_service
    ) {
        parent::__construct(static::$defaultName);

        $this->bin_list_client = $bin_list_client;
        $this->exchange_rate_client = $exchange_rate_client;
        $this->exchange_service = $exchange_service;
        $this->commission_service = $commission_service;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('file', InputArgument::REQUIRED, 'Path to CSV file')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $file = $input->getArgument('file');
        $file_reader = new JsonFileReader($file);
        $repository = new CommissionRepository($file_reader);
        $transactions = $repository->getTransactions();

        $default_currency = new Currency('EUR');

        $exchange_rate_response = $this->exchange_rate_client->get($default_currency);

        $currency_ratios = $exchange_rate_response->getCurrencyRatios();
        $this->exchange_service
            ->setSourceCurrency($default_currency)
            ->setCurrencyRatios($currency_ratios)
        ;

        foreach ($transactions as $transaction) {
            $bin_list_response = $this->bin_list_client->get($transaction->getBinNumber());
            $country_from_bin_number = new Country($bin_list_response->getCountry()->getIsoCode());

            $money = $this->exchange_service->exchange($transaction->getMoney(), $default_currency);

            $commission = $this->commission_service->calculateCommission($money, $country_from_bin_number);

            $output->writeln((string) MoneyHelper::round($commission->getValue()));
        }

        return 0;
    }
}
