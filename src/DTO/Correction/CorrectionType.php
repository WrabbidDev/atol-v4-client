<?php

declare(strict_types=1);

namespace WrDev\AtolV4Client\DTO\Correction;

enum CorrectionType: string
{
    case SELF = 'self';
    case INSTRUCTION = 'instruction';
}
