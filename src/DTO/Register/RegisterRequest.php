<?php

declare(strict_types=1);

namespace WrDev\AtolV4Client\DTO\Register;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;
use WrDev\AtolV4Client\DTO\Shared\TimestampTrait;

final class RegisterRequest
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
    #[Assert\Valid]
    private ?Service $service = null;

    #[Serializer\Type("WrDev\AtolV4Client\DTO\Register\Receipt")]
    #[Assert\Valid]
    private Receipt $receipt;

    public function __construct(string $externalId, Receipt $receipt, \DateTime $timestamp)
    {
        $this->externalId = $externalId;
        $this->receipt = $receipt;
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

    public function getReceipt(): Receipt
    {
        return $this->receipt;
    }

    public function setReceipt(Receipt $receipt): void
    {
        $this->receipt = $receipt;
    }
}
