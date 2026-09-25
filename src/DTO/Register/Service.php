<?php

declare(strict_types=1);

namespace WrDev\AtolV4Client\DTO\Register;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

final class Service
{
    #[Serializer\Type("string")]
    #[Serializer\SerializedName("callback_url")]
    #[Assert\Length(max: 256)]
    private string $callbackUrl;

    public function __construct(string $callbackUrl)
    {
        $this->callbackUrl = $callbackUrl;
    }

    public function getCallbackUrl(): string
    {
        return $this->callbackUrl;
    }

    public function setCallbackUrl(string $callbackUrl): self
    {
        $this->callbackUrl = $callbackUrl;

        return $this;
    }
}
