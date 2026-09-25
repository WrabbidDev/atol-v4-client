<?php

declare(strict_types=1);

namespace WrDev\AtolV4Client;

use JMS\Serializer\Handler\HandlerRegistryInterface;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use WrDev\AtolV4Client\Client\ApiClientInterface;
use WrDev\AtolV4Client\Common\ApiException;
use WrDev\AtolV4Client\Common\BadRequestException;
use WrDev\AtolV4Client\Client\TokenProvider;
use WrDev\AtolV4Client\Serializer\Handler\EnumHandler;
use WrDev\AtolV4Client\Serializer\Handler\ExtendedDateHandler;
use WrDev\AtolV4Client\DTO\Correction\CorrectionRequest;
use WrDev\AtolV4Client\DTO\Correction\CorrectionResponse;
use WrDev\AtolV4Client\DTO\Register\RegisterRequest;
use WrDev\AtolV4Client\DTO\Register\RegisterResponse;
use WrDev\AtolV4Client\DTO\Report\ReportResponse;

final class Client
{
    private const TOKEN_EXPIRED_ERROR_CODES = [4, 5, 6, 12, 13, 14];

    private readonly ValidatorInterface $validator;
    private readonly SerializerInterface $serializer;

    public function __construct(
        private readonly ApiClientInterface $api,
        private readonly TokenProvider $tokenProvider,
        private readonly string $groupCode,
        ?ValidatorInterface $validator = null,
        ?SerializerInterface $serializer = null,
    ) {
        if (trim($this->groupCode) === '') {
            throw new BadRequestException('Group code can not be empty.');
        }

        $this->validator = $validator ?? Validation::createValidatorBuilder()
            ->enableAttributeMapping()
            ->getValidator();
        $this->serializer = $serializer ?? $this->createSerializer();
    }

    public function sell(RegisterRequest $request): RegisterResponse
    {
        return $this->sendDocument('sell', $request, RegisterResponse::class);
    }

    public function sellRefund(RegisterRequest $request): RegisterResponse
    {
        return $this->sendDocument('sell_refund', $request, RegisterResponse::class);
    }

    public function sellCorrection(CorrectionRequest $request): CorrectionResponse
    {
        return $this->sendDocument('sell_correction', $request, CorrectionResponse::class);
    }

    public function sellCorrectionRefund(CorrectionRequest $request): CorrectionResponse
    {
        return $this->sendDocument('sell_correction_refund', $request, CorrectionResponse::class);
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
            ReportResponse::class,
        );

        return $response;
    }

    public function checkStatus(string $uuid): ReportResponse
    {
        return $this->report($uuid);
    }

    private function createSerializer(): SerializerInterface
    {
        return SerializerBuilder::create()
            ->configureHandlers(function (HandlerRegistryInterface $registry): void {
                $registry->registerSubscribingHandler(new EnumHandler());
                $registry->registerSubscribingHandler(new ExtendedDateHandler());
            })
            ->build();
    }

    private function sendDocument(string $operation, object $request, string $responseClass): object
    {
        $this->validateObject($request, 'Request');
        $payload = $this->serializeRequestToArray($request);

        return $this->sendWithTokenRetry(
            fn(string $token): array => $this->api->post($this->buildPath($operation), $payload, $token),
            $responseClass,
        );
    }

    private function sendWithTokenRetry(callable $callback, string $responseClass): object
    {
        $attempt = 0;
        while (true) {
            $token = $this->tokenProvider->get($this->api);

            try {
                $responseData = $callback($token);
                return $this->deserializeResponse($responseClass, $responseData);
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

        if (!is_array($payload)) {
            throw new BadRequestException('Unable to serialize request for ATOL Online.');
        }

        return $payload;
    }

    /** @param array<string, mixed> $responseData */
    private function deserializeResponse(string $class, array $responseData): object
    {
        $json = json_encode($responseData, JSON_THROW_ON_ERROR);
        $response = $this->serializer->deserialize($json, $class, 'atol_client');
        $this->validateObject($response, 'Response');

        return $response;
    }

    private function buildPath(string $operation): string
    {
        return trim($this->groupCode, '/') . '/' . ltrim($operation, '/');
    }

    private function isTokenExpired(ApiException $exception): bool
    {
        $details = $exception->getDetails();
        $error = $details['error'] ?? null;
        if (!is_array($error) || !isset($error['code']) || !is_int($error['code'])) {
            return false;
        }

        return in_array($error['code'], self::TOKEN_EXPIRED_ERROR_CODES, true);
    }

    private function validateObject(object $object, string $payloadType): void
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

        throw new BadRequestException($payloadType . ' validation failed: ' . implode('; ', $messages));
    }
}
