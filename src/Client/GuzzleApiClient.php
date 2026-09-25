<?php

declare(strict_types=1);

namespace WrDev\AtolV4Client\Client;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use WrDev\AtolV4Client\Common\ApiException;
use WrDev\AtolV4Client\Common\TransportException;

final class GuzzleApiClient implements ApiClientInterface
{
    public const TOKEN_IN_HEADER = 'header';
    public const TOKEN_IN_QUERY = 'query';

    public function __construct(
        private readonly ClientInterface $httpClient,
        private readonly string $tokenTransport = self::TOKEN_IN_HEADER,
    ) {
        if (!in_array($this->tokenTransport, [self::TOKEN_IN_HEADER, self::TOKEN_IN_QUERY], true)) {
            throw new \InvalidArgumentException('Unsupported token transport mode.');
        }
    }

    /** @param array<string, mixed> $payload @return array<string, mixed> */
    public function post(string $path, array $payload, ?string $token = null): array
    {
        return $this->request('POST', $path, $payload, $token);
    }

    /** @return array<string, mixed> */
    public function get(string $path, string $token): array
    {
        return $this->request('GET', $path, null, $token);
    }

    /**
     * @param array<string, mixed>|null $payload
     * @return array<string, mixed>
     */
    private function request(string $method, string $path, ?array $payload, ?string $token): array
    {
        $options = ['http_errors' => false];
        if ($payload !== null) {
            $options['json'] = $payload;
        }
        if ($token !== null) {
            if ($this->tokenTransport === self::TOKEN_IN_QUERY) {
                $separator = str_contains($path, '?') ? '&' : '?';
                $path .= $separator . 'token=' . rawurlencode($token);
            } else {
                $options['headers']['Token'] = $token;
            }
        }

        try {
            $response = $this->httpClient->request($method, ltrim($path, '/'), $options);
            $body = (string) $response->getBody();
            $data = $body === '' ? [] : json_decode($body, true, 512, JSON_THROW_ON_ERROR);
        } catch (RequestException $e) {
            throw new TransportException($e->getMessage(), previous: $e);
        } catch (GuzzleException|\JsonException $e) {
            throw new TransportException('Unable to communicate with ATOL Online.', previous: $e);
        }
        if (!is_array($data)) {
            throw new TransportException('ATOL Online returned a non-object JSON payload.');
        }

        if ($response->getStatusCode() >= 400) {
            $error = is_array($data['error'] ?? null) ? $data['error'] : [];
            throw new ApiException(
                (string) ($error['text'] ?? "ATOL Online returned HTTP {$response->getStatusCode()}."),
                $response->getStatusCode(),
                $data,
            );
        }

        if (is_array($data['error'] ?? null)) {
            throw new ApiException(
                (string) ($data['error']['text'] ?? 'ATOL Online returned an API error.'),
                details: $data,
            );
        }

        return $data;
    }
}
