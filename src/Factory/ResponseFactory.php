<?php

declare(strict_types=1);

namespace WrDev\AtolV4Client\Factory;

use JMS\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use WrDev\AtolV4Client\Common\BadRequestException;
use WrDev\AtolV4Client\DTO\Correction\CorrectionResponse;
use WrDev\AtolV4Client\DTO\Register\RegisterResponse;
use WrDev\AtolV4Client\DTO\Report\ReportResponse;

final class ResponseFactory implements ResponseFactoryInterface
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly ValidatorInterface $validator,
    ) {}

    /**
     * @param array<string, mixed> $responseData
     * @return RegisterResponse
     *
     * @throws \JsonException
     */
    public function createRegisterResponse(array $responseData): RegisterResponse
    {
        /** @var RegisterResponse */
        return $this->create(RegisterResponse::class, $responseData);
    }

    /**
     * @param array<string, mixed> $responseData
     * @return CorrectionResponse
     *
     * @throws \JsonException
     */
    public function createCorrectionResponse(array $responseData): CorrectionResponse
    {
        /** @var CorrectionResponse */
        return $this->create(CorrectionResponse::class, $responseData);
    }

    /**
     * @param array<string, mixed> $responseData
     * @return ReportResponse
     *
     * @throws \JsonException
     */
    public function createReportResponse(array $responseData): ReportResponse
    {
        /** @var ReportResponse */
        return $this->create(ReportResponse::class, $responseData);
    }

    /**
     * @param array<string, mixed> $responseData
     * @return ReportResponse
     *
     * @throws \JsonException
     */
    public function createCallbackResponse(array $responseData): ReportResponse
    {
        return $this->createReportResponse($responseData);
    }

    /**
     * @param class-string $class
     * @param array<string, mixed> $responseData
     * @return object
     *
     * @throws \JsonException
     */
    private function create(string $class, array $responseData): object
    {
        $json = json_encode($responseData, JSON_THROW_ON_ERROR);
        $response = $this->serializer->deserialize($json, $class, 'atol_client');
        $this->validateObject($response);

        return $response;
    }

    private function validateObject(object $object): void
    {
        $errors = $this->validator->validate($object);
        if (count($errors) === 0) {
            return;
        }

        $messages = [];
        foreach ($errors as $error) {
            $property = $error->getPropertyPath();
            $messages[] = ($property !== '' ? $property . ': ' : '') . $error->getMessage();
        }

        throw new BadRequestException('Response validation failed: ' . implode('; ', $messages));
    }
}
