<?php

declare(strict_types=1);

namespace WrDev\AtolV4Client\Tests;

use JMS\Serializer\SerializerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Validation;
use WrDev\AtolV4Client\Client;
use WrDev\AtolV4Client\Client\ApiClientInterface;
use WrDev\AtolV4Client\Client\TokenProvider;
use WrDev\AtolV4Client\Common\ApiException;
use WrDev\AtolV4Client\Common\BadRequestException;
use WrDev\AtolV4Client\DTO\Report\ReportResponse;

final class ClientTest extends TestCase
{
    public function testReportRetriesOnceWhenTokenExpired(): void
    {
        $api = $this->createMock(ApiClientInterface::class);
        $api->expects($this->exactly(2))
            ->method('post')
            ->with('getToken', $this->isType('array'), null)
            ->willReturnOnConsecutiveCalls(
                ['token' => 'token-1'],
                ['token' => 'token-2'],
            );

        $requestAttempt = 0;
        $api->expects($this->exactly(2))
            ->method('get')
            ->with('group-code/report/uuid-1', $this->isType('string'))
            ->willReturnCallback(function (string $path, string $token) use (&$requestAttempt): array {
                $requestAttempt++;

                if ($requestAttempt === 1) {
                    self::assertSame('token-1', $token);
                    throw new ApiException('Token expired.', 401, ['error' => ['code' => 4, 'text' => 'Expired token']]);
                }

                self::assertSame('token-2', $token);

                return [
                    'timestamp' => '25.09.2026 11:00:00',
                    'status' => 'wait',
                ];
            });

        $serializer = $this->createMock(SerializerInterface::class);
        $serializer->expects($this->once())
            ->method('deserialize')
            ->with($this->isType('string'), ReportResponse::class, 'atol_client')
            ->willReturn(new ReportResponse());

        $validator = Validation::createValidatorBuilder()->enableAttributeMapping()->getValidator();
        $client = new Client($api, new TokenProvider('login', 'password'), 'group-code', $validator, $serializer);
        $response = $client->report('uuid-1');

        self::assertInstanceOf(ReportResponse::class, $response);
    }

    public function testReportValidatesUuid(): void
    {
        $api = $this->createMock(ApiClientInterface::class);
        $serializer = $this->createMock(SerializerInterface::class);
        $validator = Validation::createValidatorBuilder()->enableAttributeMapping()->getValidator();
        $client = new Client($api, new TokenProvider('login', 'password'), 'group-code', $validator, $serializer);

        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage('UUID can not be empty.');

        $client->report('   ');
    }
}
