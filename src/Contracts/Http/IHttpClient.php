<?php

declare(strict_types=1);

namespace App\Contracts\Http;

interface IHttpClient
{
    public function get(string $url, array $options = []): IHttpResponse;
}
