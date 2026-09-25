<?php

declare(strict_types=1);

namespace WrDev\AtolV4Client\DTO\Shared;

enum ErrorType: string
{
    case NONE = 'none';
    case UNKNOWN = 'unknown';
    case SYSTEM = 'system';
    case DRIVER = 'driver';
    case TIMEOUT = 'timeout';
    case AGENT = 'agent';
}
