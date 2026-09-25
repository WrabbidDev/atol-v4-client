<?php

declare(strict_types=1);

namespace WrDev\AtolV4Client\Common;

class ApiException extends \RuntimeException
{
    /** @param array<string, mixed> $details */
    public function __construct(string $message, int $code = 0, private readonly array $details = [], ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /** @return array<string, mixed> */
    public function getDetails(): array
    {
        return $this->details;
    }
}
