<?php

declare(strict_types=1);

namespace App\Models\Http;

use App\Contracts\Http\IHttpResponse;

readonly class JsonHttpResponse implements IHttpResponse
{
    public function __construct(
        private array $data,
        private int $http_code
    ) {
        if ($this->http_code < 100 || $this->http_code > 599) {
            throw new \InvalidArgumentException('Invalid HTTP Code');
        }
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getHttpCode(): int
    {
        return $this->http_code;
    }
}
