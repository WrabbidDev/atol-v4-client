<?php

declare(strict_types=1);

namespace WrDev\AtolV4Client\DTO\Register;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

final class Vat
{
    #[Serializer\Type("Enum<'WrDev\AtolV4Client\DTO\Register\VatType'>")]
    private VatType $type;

    #[Serializer\Type("float")]
    #[Assert\Range(min: 0, max: 10000000000)]
    private float $sum;

    public function __construct(VatType $type, float $sum)
    {
        $this->type = $type;
        $this->sum = $sum;
    }

    public function getType(): VatType
    {
        return $this->type;
    }

    public function setType(VatType $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getSum(): float
    {
        return $this->sum;
    }

    public function setSum(float $sum): self
    {
        $this->sum = $sum;

        return $this;
    }
}
