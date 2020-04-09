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
        string $expectedApiKey,
        string $expectedMethod,
        string $expectedHost,
        string $expectedPath,
        array $requestBodyJsonFields = null,
        array $responseBodyJsonFields = null
    ): HttpClient
    {
        $mockResponse = self::createMock(ResponseInterface::class);

        if(!is_null($responseBodyJsonFields)) {
            $bodyString = \GuzzleHttp\json_encode((object)$responseBodyJsonFields);
            $mockResponse->method("getBody")
                ->willReturn($bodyString);
        }

        $mockClient = self::createMock(HttpClient::class);
        $mockClient->method("request")
            ->with(
                strtoupper($expectedMethod),
                self::callback(fn(UriInterface $uri) =>
                    $uri->getHost() === $expectedHost
                    && rtrim($uri->getPath(), "/") === rtrim($expectedPath, "/")
                ),
                self::callback(fn(array $array) =>
                    isset($array["headers"])
                    && isset($array["headers"]["api-key"])
                    && $array["headers"]["api-key"] === $expectedApiKey
                )
            )
            ->willReturn($mockResponse);

        return $mockClient;
    }
}