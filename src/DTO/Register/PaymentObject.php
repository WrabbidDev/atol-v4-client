<?php

declare(strict_types=1);

namespace WrDev\AtolV4Client\DTO\Register;

enum PaymentObject: string
{
    case COMMODITY = 'commodity';
    case EXCISE = 'excise';
    case JOB = 'job';
    case SERVICE = 'service';
    case GAMBLING_BET = 'gambling_bet';
    case GAMBLING_PRIZE = 'gambling_prize';
    case LOTTERY = 'lottery';
    case LOTTERY_PRIZE = 'lottery_prize';
    case INTELLECTUAL_ACTIVITY = 'intellectual_activity';
    case PAYMENT = 'payment';
    case AGENT_COMMISSION = 'agent_commission';
    case COMPOSITE = 'composite';
    case AWARD = 'award';
    case ANOTHER = 'another';
    case PROPERTY_RIGHT = 'property_right';
    case NON_OPERATING_GAIN = 'non-operating_gain';
    case INSURANCE_PREMIUM = 'insurance_premium';
    case SALES_TAX = 'sales_tax';
    case RESORT_FEE = 'resort_fee';
    case DEPOSIT = 'deposit';
    case EXPENSE = 'expense';
    case PENSION_INSURANCE_IP = 'pension_insurance_ip';
    case PENSION_INSURANCE = 'pension_insurance';
    case MEDICAL_INSURANCE_IP = 'medical_insurance_ip';
    case MEDICAL_INSURANCE = 'medical_insurance';
    case SOCIAL_INSURANCE = 'social_insurance';
    case CASINO_PAYMENT = 'casino_payment';
}
