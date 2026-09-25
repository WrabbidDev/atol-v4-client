<?php

declare(strict_types=1);

namespace WrDev\AtolV4Client\DTO\Correction;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

final class CorrectionInfo
{
    #[Serializer\Type("Enum<'WrDev\AtolV4Client\DTO\Correction\CorrectionType'>")]
    private CorrectionType $type;

    #[Serializer\Type("DateTime<'d.m.Y'>")]
    #[Serializer\SerializedName("base_date")]
    private \DateTime $baseDate;

    #[Serializer\Type("string")]
    #[Serializer\SerializedName("base_number")]
    #[Assert\NotBlank]
    private string $baseNumber;

    /**
     * Retained for backward compatibility with existing constructor usage.
     * ATOL V4 payload currently serializes only type, base_date, and base_number.
     */
    #[Serializer\Exclude]
    private ?string $description = null;

    public function __construct(CorrectionType $type, \DateTime $baseDate, string $baseNumber, ?string $description = null)
    {
        $this->type = $type;
        $this->baseDate = $baseDate;
        $this->baseNumber = $baseNumber;
        $this->description = $description;
    }

    public function getType(): CorrectionType
    {
        return $this->type;
    }

    public function setType(CorrectionType $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getBaseDate(): \DateTime
    {
        return $this->baseDate;
    }

    public function setBaseDate(\DateTime $baseDate): self
    {
        $this->baseDate = $baseDate;

        return $this;
    }

    public function getBaseNumber(): string
    {
        return $this->baseNumber;
    }

    public function setBaseNumber(string $baseNumber): self
    {
        $this->baseNumber = $baseNumber;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

}
