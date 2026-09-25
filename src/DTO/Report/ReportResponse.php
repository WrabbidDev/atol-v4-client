<?php

declare(strict_types=1);

namespace WrDev\AtolV4Client\DTO\Report;

use JMS\Serializer\Annotation as Serializer;
use WrDev\AtolV4Client\DTO\Shared\ErrorTrait;
use WrDev\AtolV4Client\DTO\Shared\TimestampTrait;
use WrDev\AtolV4Client\DTO\Shared\Warnings;

final class ReportResponse
{
    use ErrorTrait;
    use TimestampTrait;

    #[Serializer\Type("string")]
    private ?string $uuid = null;

    #[Serializer\Type("string")]
    private ?string $groupCode = null;

    #[Serializer\Type("string")]
    private ?string $daemonCode = null;

    #[Serializer\Type("string")]
    private ?string $deviceCode = null;

    #[Serializer\Type("string")]
    private ?string $callbackUrl = null;

    #[Serializer\Type("string")]
    private ?string $externalId = null;

    #[Serializer\Type("WrDev\AtolV4Client\DTO\Shared\Warnings")]
    private ?Warnings $warnings = null;

    #[Serializer\Type("Enum<'WrDev\AtolV4Client\DTO\Report\Status'>")]
    private ?Status $status = null;

    #[Serializer\Type("WrDev\AtolV4Client\DTO\Report\Payload")]
    private ?Payload $payload = null;

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function getGroupCode(): ?string
    {
        return $this->groupCode;
    }

    public function getDaemonCode(): ?string
    {
        return $this->daemonCode;
    }

    public function getDeviceCode(): ?string
    {
        return $this->deviceCode;
    }

    public function getCallbackUrl(): ?string
    {
        return $this->callbackUrl;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function getExternalId(): ?string
    {
        return $this->externalId;
    }

    public function getWarnings(): ?Warnings
    {
        return $this->warnings;
    }

    public function getPayload(): ?Payload
    {
        return $this->payload;
    }
}
