<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\ICurrency;
use App\Contracts\Http\IHttpClient;
use App\Models\ExchangeRate\ExchangeRateResponse;
use App\Contracts\ExchangeRate\IExchangeRateClient;
use App\Contracts\ExchangeRate\IExchangeRateResponse;

class ExchangeRateClient implements IExchangeRateClient
{
    protected string $url = 'https://api.apilayer.com/currency_data/live?source={source_currency}';

    public function __construct(
        private readonly IHttpClient $http_client,
        private readonly string $api_key = ''
    ) {
        if ('' === $this->api_key) {
            throw new \Exception('No API key for apilayer provided.');
        }
    }

    public function get(ICurrency $source_currency): IExchangeRateResponse
    {
        $url = $this->prepareUrl($source_currency);
        $options = $this->prepareOptions();
        $response = $this->http_client->get($url, $options);

        if (200 !== $response->getHttpCode()) {
            throw new \Exception('Invalid response from exchange service.');
        }

        $data = $response->getData();

        return new ExchangeRateResponse(
            $source_currency,
            $data['quotes']
        );
    }

    private function prepareUrl(ICurrency $source_currency): string
    {
        return str_replace('{source_currency}', $source_currency->getCurrencyCode(), $this->url);
    }

    private function prepareOptions(): array
    {
        return [
            'headers' => [
                'Content-Type' => 'application/json',
                'apikey' => $this->api_key,
            ],
        ];
    }
}
