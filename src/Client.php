<?php

declare(strict_types=1);

namespace WrDev\AtolV4Client;

use JMS\Serializer\Handler\HandlerRegistryInterface;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializerInterface;
use JMS\Serializer\Visitor\Factory\JsonDeserializationVisitorFactory;
use JMS\Serializer\Visitor\Factory\JsonSerializationVisitorFactory;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use WrDev\AtolV4Client\Client\ApiClientInterface;
use WrDev\AtolV4Client\Client\TokenProvider;
use WrDev\AtolV4Client\Common\ApiException;
use WrDev\AtolV4Client\Common\BadRequestException;
use WrDev\AtolV4Client\DTO\Correction\CorrectionRequest;
use WrDev\AtolV4Client\DTO\Correction\CorrectionResponse;
use WrDev\AtolV4Client\DTO\Register\RegisterRequest;
use WrDev\AtolV4Client\DTO\Register\RegisterResponse;
use WrDev\AtolV4Client\DTO\Report\ReportResponse;
use WrDev\AtolV4Client\Factory\ResponseFactory;
use WrDev\AtolV4Client\Factory\ResponseFactoryInterface;
use WrDev\AtolV4Client\Serializer\Handler\EnumHandler;
use WrDev\AtolV4Client\Serializer\Handler\ExtendedDateHandler;

final class Client
{
    private const TOKEN_EXPIRED_ERROR_CODES = [4, 5, 6, 12, 13, 14];

    private readonly ValidatorInterface $validator;
    private readonly SerializerInterface $serializer;
    private readonly ResponseFactoryInterface $responseFactory;

    public function __construct(
        private readonly ApiClientInterface $api,
        private readonly TokenProvider $tokenProvider,
        private readonly string $groupCode,
        ?ValidatorInterface $validator = null,
        ?SerializerInterface $serializer = null,
        ?ResponseFactoryInterface $responseFactory = null,
    ) {
        if (trim($this->groupCode) === '') {
            throw new BadRequestException('Group code can not be empty.');
        }

        $this->validator = $validator ?? self::createDefaultValidator();
        $this->serializer = $serializer ?? self::createDefaultSerializer();
        $this->responseFactory = $responseFactory ?? new ResponseFactory($this->serializer, $this->validator);
    }

    public static function createDefaultValidator(): ValidatorInterface
    {
        return Validation::createValidatorBuilder()
            ->enableAttributeMapping()
            ->getValidator();
    }

    public static function createDefaultSerializer(): SerializerInterface
    {
        return SerializerBuilder::create()
            ->setSerializationVisitor('atol_client', new JsonSerializationVisitorFactory())
            ->setDeserializationVisitor('atol_client', new JsonDeserializationVisitorFactory())
            ->configureHandlers(function (HandlerRegistryInterface $registry): void {
                $registry->registerSubscribingHandler(new EnumHandler());
                $registry->registerSubscribingHandler(new ExtendedDateHandler());
            })
            ->build();
    }

    public function sell(RegisterRequest $request): RegisterResponse
    {
        /** @var RegisterResponse $response */
        $response = $this->sendDocument(
            'sell',
            $request,
            fn(array $responseData): RegisterResponse => $this->responseFactory->createRegisterResponse($responseData),
        );

        return $response;
    }

    public function sellRefund(RegisterRequest $request): RegisterResponse
    {
        /** @var RegisterResponse $response */
        $response = $this->sendDocument(
            'sell_refund',
            $request,
            fn(array $responseData): RegisterResponse => $this->responseFactory->createRegisterResponse($responseData),
        );

        return $response;
    }

    public function sellCorrection(CorrectionRequest $request): CorrectionResponse
    {
        /** @var CorrectionResponse $response */
        $response = $this->sendDocument(
            'sell_correction',
            $request,
            fn(array $responseData): CorrectionResponse => $this->responseFactory->createCorrectionResponse($responseData),
        );

        return $response;
    }

    public function sellCorrectionRefund(CorrectionRequest $request): CorrectionResponse
    {
        /** @var CorrectionResponse $response */
        $response = $this->sendDocument(
            'sell_correction_refund',
            $request,
            fn(array $responseData): CorrectionResponse => $this->responseFactory->createCorrectionResponse($responseData),
        );

        return $response;
    }

    public function report(string $uuid): ReportResponse
    {
        $trimmedUuid = trim($uuid);
        if ($trimmedUuid === '') {
            throw new BadRequestException('UUID can not be empty.');
        }

        /** @var ReportResponse $response */
        $response = $this->sendWithTokenRetry(
            fn(string $token): array => $this->api->get($this->buildPath('report/' . rawurlencode($trimmedUuid)), $token),
            fn(array $responseData): ReportResponse => $this->responseFactory->createReportResponse($responseData),
        );

        return $response;
    }

    public function checkStatus(string $uuid): ReportResponse
    {
        return $this->report($uuid);
    }

    /**
     * @param string $operation
     * @param object $request
     * @param callable(array<string, mixed>):object $responseCreator
     * @return object
     *
     * @throws \JsonException
     */
    private function sendDocument(string $operation, object $request, callable $responseCreator): object
    {
        $this->validateObject($request);
        $payload = $this->serializeRequestToArray($request);

        return $this->sendWithTokenRetry(
            fn(string $token): array => $this->api->post($this->buildPath($operation), $payload, $token),
            $responseCreator,
        );
    }

    /**
     * @param callable(string):array<string,mixed> $callback
     * @param callable(array<string, mixed>):object $responseCreator
     *
     * @return object
     */
    private function sendWithTokenRetry(callable $callback, callable $responseCreator): object
    {
        $attempt = 0;
        while (true) {
            $token = $this->tokenProvider->get($this->api);

            try {
                $responseData = $callback($token);
                return $responseCreator($responseData);
            } catch (ApiException $exception) {
                if ($attempt === 0 && $this->isTokenExpired($exception)) {
                    $attempt++;
                    $this->tokenProvider->invalidate();
                    continue;
                }

                throw $exception;
            }
        }
    }

    /** @return array<string, mixed> */
    private function serializeRequestToArray(object $request): array
    {
        $json = $this->serializer->serialize($request, 'atol_client');
        $payload = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        if (! is_array($payload)) {
            throw new BadRequestException('Unable to serialize request for ATOL Online.');
        }

        return $payload;
    }

    private function buildPath(string $operation): string
    {
        return trim($this->groupCode, '/') . '/' . ltrim($operation, '/');
    }

    private function isTokenExpired(ApiException $exception): bool
    {
        $details = $exception->getDetails();
        $error = $details['error'] ?? null;
        if (! is_array($error) || ! isset($error['code']) || ! is_int($error['code'])) {
            return false;
        }

        return in_array($error['code'], self::TOKEN_EXPIRED_ERROR_CODES, true);
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

        throw new BadRequestException('Request validation failed: ' . implode('; ', $messages));
    }
}
