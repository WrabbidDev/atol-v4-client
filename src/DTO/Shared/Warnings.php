<?php

declare(strict_types=1);

namespace WrDev\AtolV4Client\DTO\Shared;

use JMS\Serializer\Annotation as Serializer;

final class Warnings
{
    #[Serializer\Type("string")]
    private ?string $callbackUrl = null;

    public function getCallbackUrl(): ?string
    {
        return $this->callbackUrl;
    }
}
