<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\IBinNumber;
use App\Contracts\Http\IHttpClient;
use App\Models\BinList\BinListResponse;
use App\Models\BinList\CountryResponse;
use App\Contracts\BinList\IBinListClient;
use App\Contracts\BinList\IBinListResponse;

class BinListClient implements IBinListClient
{
    protected string $url = 'https://lookup.binlist.net/{bin_number}';

    public function __construct(
        private readonly IHttpClient $http_client
    ) {
    }

    public function get(IBinNumber $bin_number): IBinListResponse
    {
        $url = $this->prepareUrl($bin_number->getValue());
        $options = $this->prepareOptions();
        $response = $this->http_client->get($url, $options);

        if (200 !== $response->getHttpCode()) {
            throw new \Exception('Invalid response from bin list service.');
        }

        $data = $response->getData();

        return new BinListResponse(
            $bin_number,
            new CountryResponse(
                $data['country']['alpha2']
            )
        );
    }

    private function prepareUrl(string $bin_number): string
    {
        return str_replace('{bin_number}', $bin_number, $this->url);
    }

    private function prepareOptions(): array
    {
        return [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
        ];
    }
}
