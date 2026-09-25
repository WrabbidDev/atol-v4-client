<?php

declare(strict_types=1);

namespace WrDev\AtolV4Client\DTO\Register;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

final class ReceivePaymentsOperator
{
    /** @var string[] */
    #[Serializer\Type("array")]
    #[Assert\Valid]
    private array $phones;

    /** @param string[] $phones */
    public function __construct(array $phones)
    {
        $this->phones = $phones;
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
