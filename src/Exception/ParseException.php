<?php

declare(strict_types=1);

namespace WrDev\AtolV4Client\Exception;

/**
 * Exception of response / request parsing.
 */
class ParseException extends \RuntimeException
{
    public const REQUEST = 1;
    public const RESPONSE = 2;

    public static function becauseOfRuntimeException(\RuntimeException $exception, int $code = 0): self
    {
        return new self('Deserialization failed.', $code, $exception);
    }
}
