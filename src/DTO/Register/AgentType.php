<?php

declare(strict_types=1);

namespace WrDev\AtolV4Client\DTO\Register;

enum AgentType: string
{
    case BANK_PAYING_AGENT = 'bank_paying_agent';
    case BANK_PAYING_SUBAGENT = 'bank_paying_subagent';
    case PAYING_AGENT = 'paying_agent';
    case PAYING_SUBAGENT = 'paying_subagent';
    case ATTORNEY = 'attorney';
    case COMMISSION_AGENT = 'commission_agent';
    case ANOTHER = 'another';
}
