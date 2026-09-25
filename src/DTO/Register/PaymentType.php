<?php

declare(strict_types=1);

namespace WrDev\AtolV4Client\DTO\Register;

enum PaymentType: int
{
    /** Cash - is not documented in atol! */
    case CASH = 0;
    case ELECTRONIC = 1;
    case PREPAID = 2;
    case POSTPAID = 3;
    case OTHER = 4;
    case EXTENDED_5 = 5;
    case EXTENDED_6 = 6;
    case EXTENDED_7 = 7;
    case EXTENDED_8 = 8;
    case EXTENDED_9 = 9;
}
