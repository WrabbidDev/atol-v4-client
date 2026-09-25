<?php

declare(strict_types=1);

namespace WrDev\AtolV4Client\DTO\Register;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

final class Client
{
    #[Serializer\Type("string")]
    #[Assert\Length(max: 256)]
    private ?string $name = null;

    #[Serializer\Type("string")]
    #[Assert\Regex(pattern: "/(^[0-9]{10}$)|(^[0-9]{12}$)/")]
    private ?string $inn = null;

    #[Serializer\Type("string")]
    #[Assert\Length(max: 64)]
    private ?string $email = null;

    #[Serializer\Type("string")]
    #[Assert\Length(max: 64)]
    private ?string $phone = null;

    #[Assert\Callback]
    public function validateContacts(ExecutionContextInterface $context): void
    {
        $email = $this->normalizeContact($this->email);
        $phone = $this->normalizeContact($this->phone);

        if ($email === null && $phone === null) {
            $context
                ->buildViolation('Either email or phone must be provided')
                ->atPath('email')
                ->addViolation();

            return;
        }

        if ($email !== null && !preg_match('/^.+@.+$/', $email)) {
            $context
                ->buildViolation('Email must look like user@domain')
                ->atPath('email')
                ->addViolation();
        }

        if ($phone !== null && !preg_match('/^\+\d+$/', $phone)) {
            $context
                ->buildViolation('Phone must be in +digits format')
                ->atPath('phone')
                ->addViolation();
        }
    }

    public function __construct(?string $email, ?string $phone, ?string $name = null, ?string $inn = null)
    {
        $this->name = $name;
        $this->inn = $inn;
        $this->email = $email;
        $this->phone = $phone;

        $this->assertValidity();
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getInn(): ?string
    {
        return $this->inn;
    }

    public function setInn(?string $inn): self
    {
        $this->inn = $inn;

        return $this;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;
        $this->assertValidity();

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;
        $this->assertValidity();

        return $this;
    }

    private function assertValidity(): void
    {
        if ($this->normalizeContact($this->email) === null && $this->normalizeContact($this->phone) === null) {
            throw new \InvalidArgumentException('Email and phone can not be empty at the same time');
        }
    }

    private function normalizeContact(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $trimmed = trim($value);

        return $trimmed === '' ? null : $trimmed;
    }
}
