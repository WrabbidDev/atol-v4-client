<?php

declare(strict_types=1);

namespace WrDev\AtolV4Client\DTO\Register;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

final class CashlessPayment
{
    #[Serializer\Type("float")]
    #[Assert\Range(min: 0, max: 10000000000)]
    private float $sum;

    #[Serializer\Type("int")]
    #[Assert\Range(min: 0, max: 255)]
    private int $method;

    #[Serializer\Type("string")]
    #[Assert\Length(min: 1, max: 256)]
    private string $id;

    #[Serializer\Type("string")]
    #[Serializer\SerializedName("additional_info")]
    #[Assert\Length(min: 1, max: 256)]
    private ?string $additionalInfo = null;

    public function __construct(float $sum, int $method, string $id)
    {
        $this->sum = $sum;
        $this->method = $method;
        $this->id = $id;
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

    public function getMethod(): int
    {
        return $this->method;
    }

    public function setMethod(int $method): self
    {
        $this->method = $method;

        return $this;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getAdditionalInfo(): ?string
    {
        return $this->additionalInfo;
    }

    public function setAdditionalInfo(?string $additionalInfo): self
    {
        $this->additionalInfo = $additionalInfo;

        return $this;
    }
}
