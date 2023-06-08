<?php

declare(strict_types=1);

namespace App\Contracts\Http;

interface IHttpResponse
{
    public function getData(): array;

    public function getHttpCode(): int;
}
