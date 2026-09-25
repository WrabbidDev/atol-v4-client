<?php

declare(strict_types=1);

namespace WrDev\AtolV4Client\DTO\Register;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

final class AgentInfo
{
    #[Serializer\Type("Enum<'WrDev\AtolV4Client\DTO\Register\AgentType'>")]
    private AgentType $type;

    #[Serializer\Type("WrDev\AtolV4Client\DTO\Register\PayingAgent")]
    #[Assert\Valid]
    private ?PayingAgent $payingAgent = null;

    #[Serializer\Type("WrDev\AtolV4Client\DTO\Register\ReceivePaymentsOperator")]
    #[Serializer\SerializedName("receive_payments_operator")]
    #[Assert\Valid]
    private ?ReceivePaymentsOperator $receivePaymentsOperator = null;

    #[Serializer\Type("WrDev\AtolV4Client\DTO\Register\MoneyTransferOperator")]
    #[Serializer\SerializedName("money_transfer_operator")]
    #[Assert\Valid]
    private ?MoneyTransferOperator $moneyTransferOperator = null;

    public function __construct(AgentType $type)
    {
        $this->type = $type;
    }

    public function getType(): AgentType
    {
        return $this->type;
    }

    public function setType(AgentType $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getPayingAgent(): ?PayingAgent
    {
        return $this->payingAgent;
    }

    public function setPayingAgent(?PayingAgent $payingAgent): self
    {
        $this->payingAgent = $payingAgent;

        return $this;
    }

    public function getReceivePaymentsOperator(): ?ReceivePaymentsOperator
    {
        return $this->receivePaymentsOperator;
    }

    public function setReceivePaymentsOperator(?ReceivePaymentsOperator $receivePaymentsOperator): self
    {
        $this->receivePaymentsOperator = $receivePaymentsOperator;

        return $this;
    }

    public function getMoneyTransferOperator(): ?MoneyTransferOperator
    {
        return $this->moneyTransferOperator;
    }

    public function setMoneyTransferOperator(?MoneyTransferOperator $moneyTransferOperator): self
    {
        $this->moneyTransferOperator = $moneyTransferOperator;

        return $this;
    }
}
