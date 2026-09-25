<?php

declare(strict_types=1);

namespace WrDev\AtolV4Client\Common;

class AuthenticationException extends \RuntimeException
{
    /** @param array<string, mixed> $details */
    public function __construct(string $message, private readonly array $details = [], ?\Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }

    /** @return array<string, mixed> */
    public function getDetails(): array
    {
        return $this->details;
    }
}
