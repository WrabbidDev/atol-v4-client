<?php

declare(strict_types=1);

namespace WrDev\AtolV4Client\DTO\GetToken;

use JMS\Serializer\Annotation as Serializer;
use WrDev\AtolV4Client\DTO\Shared\ErrorTrait;
use WrDev\AtolV4Client\DTO\Shared\TimestampTrait;

final class GetTokenResponse
{
    use TimestampTrait;
    use ErrorTrait;

    #[Serializer\Type("string")]
    private ?string $token = null;

    public function getToken(): ?string
    {
        return $this->token;
    }
}
