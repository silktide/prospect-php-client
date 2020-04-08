<?php

namespace Silktide\ProspectClient\UnitTest;

use GuzzleHttp\Client as HttpClient;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

class HttpTestCase extends TestCase
{
    /**
     * Return a mocked Guzzle Client object that is preconfigured with
     * the expected request parameters.
     *
     * @return HttpClient|MockObject
     */
    protected function mockHttpClient(
        string $apiKey,
        string $method,
        string $host,
        string $path
    ): HttpClient
    {
        $mockResponse = self::createMock(ResponseInterface::class);

        $mockClient = self::createMock(HttpClient::class);
        $mockClient->expects(self::once())
            ->method("request")
            ->with(
                strtoupper($method),
                self::callback(fn(UriInterface $uri) =>
                    $uri->getHost() === $host
                    && $uri->getPath() === $path
                ),
                self::callback(fn(array $array) =>
                    isset($array["headers"])
                    && isset($array["headers"]["api-key"])
                    && $array["headers"]["api-key"] === $apiKey
                )
            )
            ->willReturn($mockResponse);

        return $mockClient;
    }
}