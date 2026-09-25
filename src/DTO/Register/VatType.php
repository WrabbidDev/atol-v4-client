<?php

declare(strict_types=1);

namespace WrDev\AtolV4Client\DTO\Register;

enum VatType: string
{
    case NONE = 'none';
    case VAT0 = 'vat0';
    case VAT5 = 'vat5';
    case VAT7 = 'vat7';
    case VAT10 = 'vat10';
    case VAT18 = 'vat18';
    case VAT20 = 'vat20';
    case VAT22 = 'vat22';
    case VAT105 = 'vat105';
    case VAT107 = 'vat107';
    case VAT110 = 'vat110';
    case VAT118 = 'vat118';
    case VAT120 = 'vat120';
    case VAT122 = 'vat122';
}
