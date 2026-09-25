<?php

declare(strict_types=1);

namespace WrDev\AtolV4Client\DTO\Shared;

use JMS\Serializer\Annotation as Serializer;

/**
 * ATOL timestamp holder.
 * Exists in requests and responses.
 */
trait TimestampTrait
{
    #[Serializer\Type("DateTime<'d.m.Y H:i:s', 'Europe/Moscow'>")]
    private \DateTime $timestamp;

    /**
     * @return \DateTime
     */
    public function getTimestamp(): \DateTime
    {
        return $this->timestamp;
    }
}
