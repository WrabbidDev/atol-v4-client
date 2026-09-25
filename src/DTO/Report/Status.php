<?php

declare(strict_types=1);

namespace WrDev\AtolV4Client\DTO\Report;

enum Status: string
{
    case DONE = 'done';
    case FAIL = 'fail';
    case WAIT = 'wait';
}
