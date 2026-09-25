<?php

declare(strict_types=1);

namespace WrDev\AtolV4Client\Converter;

use WrDev\AtolV4Client\Exception\ParseException;
use WrDev\AtolV4Client\Exception\ValidationException;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Converts request and response from and to json.
 */
class ObjectConverter
{
    private SerializerInterface $serializer;

    private ValidatorInterface $validator;

    public function __construct(
        SerializerInterface $serializer,
        ValidatorInterface $validator,
    ) {
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    /**
     * @param string $class
     * @param string $json
     *
     * @throws ValidationException
     * @throws ParseException
     *
     * @return mixed
     */
    public function getResponseObject(string $class, string $json): mixed
    {
        $object = $this->deserialize($class, $json);
        $this->assertValid($object, ValidationException::RESPONSE);

        return $object;
    }

    /**
     * @param mixed $object
     *
     * @throws ValidationException
     * @throws ParseException
     *
     * @return string
     */
    public function getRequestString(mixed $object): string
    {
        $this->assertValid($object, ValidationException::REQUEST);

        return $this->serializeBodyObject($object);
    }

    /**
     * @param string $class
     * @param string $json
     *
     * @throws ParseException
     *
     * @return mixed
     */
    private function deserialize(string $class, string $json): mixed
    {
        try {
            return $this->serializer->deserialize($json, $class, 'atol_client');
        } catch (\RuntimeException $exception) {
            throw ParseException::becauseOfRuntimeException($exception, ParseException::RESPONSE);
        }
    }

    /**
     * Assert that object is valid.
     *
     * @param mixed $object
     * @param int $code
     *
     * @throws ValidationException
     */
    private function assertValid(mixed $object, int $code = 0): void
    {
        $errors = $this->validator->validate($object);
        if (count($errors)) {
            throw ValidationException::becauseOfValidationErrors($errors, $code);
        }
    }

    /**
     * @param mixed $object
     *
     * @throws ParseException
     *
     * @return string
     */
    private function serializeBodyObject(mixed $object): string
    {
        try {
            return $this->serializer->serialize($object, 'atol_client', $this->getSerializeBodyObjectContext());
        } catch (\RuntimeException $exception) {
            throw ParseException::becauseOfRuntimeException($exception, ParseException::REQUEST);
        }
    }

    private function getSerializeBodyObjectContext(): SerializationContext
    {
        return SerializationContext::create()->setGroups(['Default', 'post']);
    }
}
