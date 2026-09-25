<?php

declare(strict_types=1);

namespace WrDev\AtolV4Client\DTO\Register;

enum Status: string
{
    case FAIL = 'fail';
    case WAIT = 'wait';
}
