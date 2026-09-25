<?php

declare(strict_types=1);

namespace WrDev\AtolV4Client\DTO\Correction;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;
use WrDev\AtolV4Client\DTO\Register\Service;
use WrDev\AtolV4Client\DTO\Shared\TimestampTrait;

final class CorrectionRequest
{
    use TimestampTrait;

    #[Serializer\Type("string")]
    #[Serializer\SerializedName("external_id")]
    #[Assert\Length(max: 128)]
    private string $externalId;

    #[Serializer\Type("int")]
    #[Serializer\SerializedName("source_id")]
    #[Assert\Range(min: 0, max: 9)]
    private ?int $sourceId = null;

    #[Serializer\Type("WrDev\AtolV4Client\DTO\Register\Service")]
    private ?Service $service = null;

    #[Serializer\Type("WrDev\AtolV4Client\DTO\Correction\Correction")]
    #[Assert\Valid]
    private Correction $correction;

    public function __construct(string $externalId, Correction $correction, \DateTime $timestamp)
    {
        $this->externalId = $externalId;
        $this->correction = $correction;
        $this->timestamp = $timestamp;
    }

    public function setTimestamp(\DateTime $timestamp): self
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    public function getExternalId(): string
    {
        return $this->externalId;
    }

    public function setExternalId(string $externalId): void
    {
        $this->externalId = $externalId;
    }

    public function getSourceId(): ?int
    {
        return $this->sourceId;
    }

    public function setSourceId(?int $sourceId): self
    {
        $this->sourceId = $sourceId;

        return $this;
    }

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): void
    {
        $this->service = $service;
    }

    public function getCorrection(): Correction
    {
        return $this->correction;
    }

    public function setCorrection(Correction $correction): self
    {
        $this->correction = $correction;

        return $this;
    }

}
