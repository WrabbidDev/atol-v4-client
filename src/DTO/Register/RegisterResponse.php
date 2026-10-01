<?php

declare(strict_types=1);

namespace WrDev\AtolV4Client\DTO\Register;

use JMS\Serializer\Annotation as Serializer;
use WrDev\AtolV4Client\DTO\Report\Payload;
use WrDev\AtolV4Client\DTO\Shared\ErrorTrait;
use WrDev\AtolV4Client\DTO\Shared\TimestampTrait;
use WrDev\AtolV4Client\DTO\Shared\Warnings;

final class RegisterResponse
{
    use TimestampTrait;
    use ErrorTrait;

    #[Serializer\Type("string")]
    private ?string $uuid = null;

    #[Serializer\Type("Enum<'WrDev\AtolV4Client\DTO\Register\Status'>")]
    private ?Status $status = null;

    #[Serializer\Type("string")]
    #[Serializer\SerializedName("group_code")]
    private ?string $groupCode = null;

    #[Serializer\Type("string")]
    #[Serializer\SerializedName("daemon_code")]
    private ?string $daemonCode = null;

    #[Serializer\Type("string")]
    #[Serializer\SerializedName("device_code")]
    private ?string $deviceCode = null;

    #[Serializer\Type("string")]
    #[Serializer\SerializedName("external_id")]
    private ?string $externalId = null;

    #[Serializer\Type("string")]
    #[Serializer\SerializedName("callback_url")]
    private ?string $callbackUrl = null;

    #[Serializer\Type("WrDev\AtolV4Client\DTO\Shared\Warnings")]
    private ?Warnings $warnings = null;

    #[Serializer\Type("WrDev\AtolV4Client\DTO\Report\Payload")]
    private ?Payload $payload = null;

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
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

    public function getExternalId(): ?string
    {
        return $this->externalId;
    }

    public function getCallbackUrl(): ?string
    {
        return $this->callbackUrl;
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
