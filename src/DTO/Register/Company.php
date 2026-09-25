<?php

declare(strict_types=1);

namespace WrDev\AtolV4Client\DTO\Register;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

final class Company
{
    #[Serializer\Type("string")]
    #[Assert\Length(max: 64)]
    private string $email;
    #[Serializer\Type("Enum<'WrDev\AtolV4Client\DTO\Register\Sno'>")]
    private ?Sno $sno = null;
    #[Serializer\Type("string")]
    #[Assert\Length(max: 12)]
    private string $inn;
    #[Serializer\Type("string")]
    #[Serializer\SerializedName("payment_address")]
    #[Assert\Length(max: 256)]
    private string $paymentAddress;

    #[Serializer\Type("string")]
    #[Assert\Length(max: 256)]
    private ?string $location = null;

    public function __construct(string $email, string $inn, string $paymentAddress)
    {
        $this->email = $email;
        $this->inn = $inn;
        $this->paymentAddress = $paymentAddress;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getSno(): ?Sno
    {
        return $this->sno;
    }

    public function setSno(?Sno $sno): self
    {
        $this->sno = $sno;

        return $this;
    }

    public function getInn(): string
    {
        return $this->inn;
    }

    public function setInn(string $inn): self
    {
        $this->inn = $inn;

        return $this;
    }

    public function getPaymentAddress(): string
    {
        return $this->paymentAddress;
    }

    public function setPaymentAddress(string $paymentAddress): self
    {
        $this->paymentAddress = $paymentAddress;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): self
    {
        $this->location = $location;

        return $this;
    }
}
