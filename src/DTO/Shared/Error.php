<?php

declare(strict_types=1);

namespace WrDev\AtolV4Client\DTO\Shared;

use JMS\Serializer\Annotation as Serializer;

final class Error
{
    #[Serializer\Type("string")]
    #[Serializer\SerializedName("error_id")]
    private ?string $errorId = null;
    #[Serializer\Type("int")]
    private ?int $code = null;

    #[Serializer\Type("string")]
    private ?string $text = null;

    #[Serializer\Type("Enum<'WrDev\AtolV4Client\DTO\Shared\ErrorType'>")]
    private ?ErrorType $type = null;

    public function getErrorId(): ?string
    {
        return $this->errorId;
    }

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function getType(): ?ErrorType
    {
        return $this->type;
    }
}
