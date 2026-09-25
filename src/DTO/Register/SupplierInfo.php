<?php

declare(strict_types=1);

namespace WrDev\AtolV4Client\DTO\Register;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

final class SupplierInfo
{
    /** @var string[] */
    #[Serializer\Type("array")]
    #[Assert\Valid]
    private array $phones;
    #[Serializer\Type("string")]
    private string $name;
    #[Serializer\Type("string")]
    #[Assert\Regex(pattern: "/(^[0-9]{10}$)|(^[0-9]{12}$)/")]
    private string $inn;

    /** @param string[] $phones */
    public function __construct(array $phones, string $name, string $inn)
    {
        $this->phones = $phones;
        $this->name = $name;
        $this->inn = $inn;
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

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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
}
