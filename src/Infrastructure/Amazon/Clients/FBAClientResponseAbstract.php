<?php

declare(strict_types=1);

namespace App\Infrastructure\Amazon\Clients;

abstract class FBAClientResponseAbstract
{
    public function __construct(
        protected int $statusCode,
        protected array $body,
        protected ?string $errorMessage = null,
        protected array $headers = []
    ) {}

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function isSuccess(): bool
    {
        return $this->statusCode === 200;
    }

    public function getBody(): array
    {
        return $this->body;
    }

    public function getErrorMessage(): ?string
    {
        return $this->errorMessage;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }
}
