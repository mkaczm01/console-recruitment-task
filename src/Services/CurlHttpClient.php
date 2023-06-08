<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\Http\IHttpClient;
use App\Contracts\Http\IHttpResponse;
use App\Models\Http\JsonHttpResponse;

class CurlHttpClient implements IHttpClient
{
    protected \CurlHandle $ch;

    public function __construct()
    {
        $this->ch = \curl_init();
    }

    public function get(string $url, array $options = []): IHttpResponse
    {
        $this->setConnectionOptions($options);
        curl_setopt($this->ch, CURLOPT_URL, $url);

        $response = curl_exec($this->ch);
        if (false === $response) {
            throw new \Exception('HTTP Client error.');
        }

        $response_data = curl_getinfo($this->ch);
        $json_data = $this->decodeJsonResponse($response);

        curl_close($this->ch);

        return new JsonHttpResponse(
            $json_data,
            $response_data['http_code']
        );
    }

    private function setConnectionOptions(array $additional_options = []): void
    {
        $headers = [];
        $headers[] = '';

        if (isset($additional_options['headers'])) {
            foreach ($additional_options['headers'] as $name => $value) {
                $headers[] = $name.': '.$value;
            }
        }

        $options = [
            CURLOPT_HEADER => false,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERAGENT => 'RecruitmentTask Application v0.0.1',
        ];

        curl_setopt_array($this->ch, $options);
    }

    private function decodeJsonResponse(string $response): array
    {
        return \json_decode($response, true, 512, JSON_THROW_ON_ERROR);
    }

    public function __destruct()
    {
        curl_close($this->ch);
    }
}
