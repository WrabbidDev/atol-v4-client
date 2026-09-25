<?php

declare(strict_types=1);

namespace WrDev\AtolV4Client\Serializer\Handler;

use JMS\Serializer\GraphNavigatorInterface;
use JMS\Serializer\Handler\DateHandler;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Visitor\DeserializationVisitorInterface;
use JMS\Serializer\Visitor\SerializationVisitorInterface;

/**
 * Add support of different formats for DateTime and DateInterval JMS type.
 */
class ExtendedDateHandler implements SubscribingHandlerInterface
{
    /** @var list<string> */
    private static array $additionalFormats = [
        'atol_client',
    ];

    /** @var list<string> */
    private static array $types = [
        'DateTime',
        'DateInterval',
    ];

    /** @var DateHandler there is no DI */
    private $dateHandler;

    public function __construct()
    {
        $this->dateHandler = new DateHandler();
    }

    /**
     * {@inheritdoc}
     */
    /** @return array<int, array<string, mixed>> */
    public static function getSubscribingMethods(): array
    {
        $methods = DateHandler::getSubscribingMethods();

        foreach (self::$additionalFormats as $format) {
            $methods[] = [
                'type' => 'DateTime',
                'direction' => GraphNavigatorInterface::DIRECTION_DESERIALIZATION,
                'format' => $format,
                'method' => 'deserializeDateTimeFromJson',
            ];

            foreach (self::$types as $type) {
                $methods[] = [
                    'type' => $type,
                    'format' => $format,
                    'direction' => GraphNavigatorInterface::DIRECTION_SERIALIZATION,
                    'method' => 'serialize' . $type,
                ];
            }
        }

        return $methods;
    }

    /**
     * @param array<string, mixed> $type
     */
    public function serializeDateTime(SerializationVisitorInterface $visitor, \DateTime $date, array $type, SerializationContext $context): mixed
    {
        return $this->dateHandler->serializeDateTime($visitor, $date, $type, $context);
    }

    /**
     * @param array<string, mixed> $type
     */
    public function serializeDateTimeImmutable(
        SerializationVisitorInterface $visitor,
        \DateTimeImmutable $date,
        array $type,
        SerializationContext $context,
    ): mixed {
        return $this->dateHandler->serializeDateTimeImmutable($visitor, $date, $type, $context);
    }

    /**
     * @param array<string, mixed> $type
     */
    public function serializeDateInterval(SerializationVisitorInterface $visitor, \DateInterval $date, array $type, SerializationContext $context): mixed
    {
        return $this->dateHandler->serializeDateInterval($visitor, $date, $type, $context);
    }

    /**
     * @param mixed $data
     * @param array<string, mixed> $type
     */
    public function deserializeDateTimeFromJson(DeserializationVisitorInterface $visitor, mixed $data, array $type): ?\DateTimeInterface
    {
        return $this->dateHandler->deserializeDateTimeFromJson($visitor, $data, $type);
    }
}
