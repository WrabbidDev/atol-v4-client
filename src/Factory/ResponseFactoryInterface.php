<?php

declare(strict_types=1);

namespace WrDev\AtolV4Client\Factory;

use WrDev\AtolV4Client\DTO\Correction\CorrectionResponse;
use WrDev\AtolV4Client\DTO\Register\RegisterResponse;
use WrDev\AtolV4Client\DTO\Report\ReportResponse;

interface ResponseFactoryInterface
{
    /** @param array<string, mixed> $responseData */
    public function createRegisterResponse(array $responseData): RegisterResponse;

    /** @param array<string, mixed> $responseData */
    public function createCorrectionResponse(array $responseData): CorrectionResponse;

    /** @param array<string, mixed> $responseData */
    public function createReportResponse(array $responseData): ReportResponse;

    /** @param array<string, mixed> $responseData */
    public function createCallbackResponse(array $responseData): ReportResponse;
}
