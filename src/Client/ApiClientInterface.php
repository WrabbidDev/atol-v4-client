<?php

declare(strict_types=1);

namespace WrDev\AtolV4Client\Client;

interface ApiClientInterface
{
    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    public function post(string $path, array $payload, ?string $token = null): array;

    /** @return array<string, mixed> */
    public function get(string $path, string $token): array;
}
