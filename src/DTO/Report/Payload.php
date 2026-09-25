<?php

declare(strict_types=1);

namespace WrDev\AtolV4Client\DTO\Report;

use JMS\Serializer\Annotation as Serializer;

class Payload
{
    #[Serializer\Type("integer")]
    private ?int $fiscalReceiptNumber = null;

    #[Serializer\Type("integer")]
    private ?int $shiftNumber = null;

    #[Serializer\Type("DateTime<'d.m.Y G:i:s', 'Europe/Moscow'>")]
    private ?\DateTimeInterface $receiptDatetime = null;

    #[Serializer\Type("float")]
    private ?float $total = null;

    #[Serializer\Type("string")]
    private ?string $fnNumber = null;

    #[Serializer\Type("string")]
    private ?string $ecrRegistrationNumber = null;

    #[Serializer\Type("integer")]
    private ?int $fiscalDocumentNumber = null;

    #[Serializer\Type("integer")]
    private ?int $fiscalDocumentAttribute = null;

    #[Serializer\Type("string")]
    private ?string $fnsSite = null;

    #[Serializer\Type("string")]
    private ?string $ofdInn = null;

    #[Serializer\Type("string")]
    private ?string $ofdReceiptUrl = null;

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function getFnNumber(): ?string
    {
        return $this->fnNumber;
    }

    public function getShiftNumber(): ?int
    {
        return $this->shiftNumber;
    }

    public function getReceiptDatetime(): ?\DateTimeInterface
    {
        return $this->receiptDatetime;
    }

    public function getFiscalReceiptNumber(): ?int
    {
        return $this->fiscalReceiptNumber;
    }

    public function getFiscalDocumentNumber(): ?int
    {
        return $this->fiscalDocumentNumber;
    }

    public function getEcrRegistrationNumber(): ?string
    {
        return $this->ecrRegistrationNumber;
    }

    public function getFiscalDocumentAttribute(): ?int
    {
        return $this->fiscalDocumentAttribute;
    }

    public function getFnsSite(): ?string
    {
        return $this->fnsSite;
    }

    public function getOfdInn(): ?string
    {
        return $this->ofdInn;
    }

    public function getOfdReceiptUrl(): ?string
    {
        return $this->ofdReceiptUrl;
    }
}
