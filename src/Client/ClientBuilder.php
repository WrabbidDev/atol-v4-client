<?php

declare(strict_types=1);

namespace WrDev\AtolV4Client\Client;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface;
use InvalidArgumentException;
use WrDev\AtolV4Client\Client;

final class ClientBuilder
{
    public const PRODUCTION_URL = 'https://online.atol.ru/possystem/v4/';
    public const TEST_URL = 'https://testonline.atol.ru/possystem/v4/';

    private ?string $login = null;
    private ?string $password = null;
    private ?string $groupCode = null;
    private string $baseUri = self::PRODUCTION_URL;
    private string $tokenTransport = GuzzleApiClient::TOKEN_IN_HEADER;
    private ?ClientInterface $httpClient = null;

    public function setAuth(string $login, string $password): self
    {
        $copy = clone $this;
        $copy->login = $login;
        $copy->password = $password;
        return $copy;
    }

    public function setGroupCode(string $groupCode): self
    {
        $copy = clone $this;
        $copy->groupCode = $groupCode;
        return $copy;
    }

    public function useTestEnvironment(): self
    {
        $copy = clone $this;
        $copy->baseUri = self::TEST_URL;
        return $copy;
    }

    public function setBaseUri(string $baseUri): self
    {
        $copy = clone $this;
        $copy->baseUri = rtrim($baseUri, '/') . '/';
        return $copy;
    }

    public function setHttpClient(ClientInterface $httpClient): self
    {
        $copy = clone $this;
        $copy->httpClient = $httpClient;
        return $copy;
    }

    public function useTokenInHeader(): self
    {
        $copy = clone $this;
        $copy->tokenTransport = GuzzleApiClient::TOKEN_IN_HEADER;
        return $copy;
    }

    public function useTokenInQuery(): self
    {
        $copy = clone $this;
        $copy->tokenTransport = GuzzleApiClient::TOKEN_IN_QUERY;
        return $copy;
    }

    public function build(): Client
    {
        if ($this->login === null || $this->password === null || $this->groupCode === null) {
            throw new InvalidArgumentException('Login, password, and group code are required.');
        }

        $http = $this->httpClient ?? new GuzzleClient(['base_uri' => $this->baseUri]);
        return new Client(
            new GuzzleApiClient($http, $this->tokenTransport),
            new TokenProvider($this->login, $this->password),
            $this->groupCode,
        );
    }
}
