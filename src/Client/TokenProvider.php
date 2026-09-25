<?php

declare(strict_types=1);

namespace WrDev\AtolV4Client\Client;

use WrDev\AtolV4Client\Common\AuthenticationException;

final class TokenProvider
{
    private ?string $token = null;
    private ?\DateTimeImmutable $expiresAt = null;

    public function __construct(
        private readonly string $login,
        private readonly string $password,
    ) {}

    public function get(ApiClientInterface $api): string
    {
        if ($this->token !== null && $this->expiresAt !== null && $this->expiresAt > new \DateTimeImmutable('+30 seconds')) {
            return $this->token;
        }

        try {
            $response = $api->post('getToken', ['login' => $this->login, 'pass' => $this->password]);
        } catch (\Throwable $e) {
            throw new AuthenticationException('Unable to obtain an ATOL Online token.', previous: $e);
        }

        $token = $response['token'] ?? null;
        if (!is_string($token) || $token === '') {
            throw new AuthenticationException((string) (($response['error']['text'] ?? null) ?: 'ATOL Online did not return a token.'), details: $response);
        }

        $this->token = $token;
        $this->expiresAt = isset($response['expires_at']) && is_string($response['expires_at'])
            ? new \DateTimeImmutable($response['expires_at'])
            : new \DateTimeImmutable('+23 hours');

        return $token;
    }

    public function invalidate(): void
    {
        $this->token = null;
        $this->expiresAt = null;
    }
}
