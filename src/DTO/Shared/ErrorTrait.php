<?php

declare(strict_types=1);

namespace WrDev\AtolV4Client\DTO\Shared;

use JMS\Serializer\Annotation as Serializer;

trait ErrorTrait
{
    #[Serializer\Type("WrDev\AtolV4Client\DTO\Shared\Error")]
    private ?Error $error = null;

    public function getError(): ?Error
    {
        return $this->error;
    }
}
