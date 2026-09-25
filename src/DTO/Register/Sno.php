<?php

declare(strict_types=1);

namespace WrDev\AtolV4Client\DTO\Register;

enum Sno: string
{
    case OSN = 'osn';
    case USN_INCOME = 'usn_income';
    case USN_INCOME_OUTCOME = 'usn_income_outcome';
    case ENVD = 'envd';
    case ESN = 'esn';
    case PATENT = 'patent';
}
