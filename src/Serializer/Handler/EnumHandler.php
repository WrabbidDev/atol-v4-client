<?php

declare(strict_types=1);

namespace WrDev\AtolV4Client\Serializer\Handler;

use JMS\Serializer\GraphNavigator;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\Visitor\DeserializationVisitorInterface;
use JMS\Serializer\Visitor\SerializationVisitorInterface;
use BackedEnum;

/**
 * Adds support of "Enum" type for JMS.
 */
class EnumHandler implements SubscribingHandlerInterface
{
    /** @var list<string> */
    private static array $formats = [
        'atol_client',
    ];

    /**
     * {@inheritdoc}
     */
    /** @return array<int, array<string, mixed>> */
    public static function getSubscribingMethods(): array
    {
        $methods = [];

        foreach (self::$formats as $format) {
            $methods[] = [
                'type' => 'Enum',
                'direction' => GraphNavigator::DIRECTION_DESERIALIZATION,
                'format' => $format,
                'method' => 'deserialize',
            ];

            $methods[] = [
                'type' => 'Enum',
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'format' => $format,
                'method' => 'serialize',
            ];
        }

        return $methods;
    }

    /**
     * @param DeserializationVisitorInterface $visitor
     * @param mixed            $data
     * @param array<string, mixed> $type
     *
     * @return BackedEnum|null
     */
    public function deserialize(DeserializationVisitorInterface $visitor, mixed $data, array $type): ?BackedEnum
    {
        if ($data === null) {
            return null;
        }

        // Return enum if exists:
        $class = $type['params'][0] ?? null;
        if (\is_string($class) && enum_exists($class) && is_subclass_of($class, BackedEnum::class)) {
            return $class::from($data);
        }

        throw new \LogicException('Enum class does not exist.');
    }

    /**
     * @param SerializationVisitorInterface $visitor
     * @param BackedEnum       $enum
     * @param array<string, mixed> $type
     * @throws \LogicException
     *
     * @return mixed
     */
    public function serialize(SerializationVisitorInterface $visitor, BackedEnum $enum, array $type): mixed
    {
        $valueType = $type['params'][1] ?? (\is_int($enum->value) ? 'integer' : 'string');
        switch ($valueType) {
            case 'string':
                return $visitor->visitString((string) $enum->value, $type);
            case 'integer':
                return $visitor->visitInteger((int) $enum->value, $type);
            default:
                throw new \LogicException('Unknown value type ');
        }
    }
}
