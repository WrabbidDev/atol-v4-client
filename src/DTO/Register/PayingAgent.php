<?php

declare(strict_types=1);

namespace WrDev\AtolV4Client\DTO\Register;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

final class PayingAgent
{
    #[Serializer\Type("string")]
    private string $operation;

    /** @var string[] */
    #[Serializer\Type("array")]
    #[Assert\Valid]
    private array $phones;

    /** @param string[] $phones */
    public function __construct(string $operation, array $phones)
    {
        $this->operation = $operation;
        $this->phones = $phones;
    }

    public function getOperation(): string
    {
        return $this->operation;
    }

    public function setOperation(string $operation): self
    {
        $this->operation = $operation;

        return $this;
    }

    /** @return string[] */
    public function getPhones(): array
    {
        return $this->phones;
    }

    /** @param string[] $phones */
    public function setPhones(array $phones): self
    {
        $this->phones = $phones;

        return $this;
    }
}
