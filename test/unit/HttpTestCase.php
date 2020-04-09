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
        string $path,
        array $bodyJsonFields = null
    ): HttpClient
    {
        $mockResponse = self::createMock(ResponseInterface::class);

        if(!is_null($bodyJsonFields)) {
            $bodyString = \GuzzleHttp\json_encode((object)$bodyJsonFields);
            $mockResponse->method("getBody")
                ->willReturn($bodyString);
        }

        $mockClient = self::createMock(HttpClient::class);
        $mockClient->method("request")
            ->with(
                strtoupper($method),
                self::callback(fn(UriInterface $uri) =>
                    $uri->getHost() === $host
                    && rtrim($uri->getPath(), "/") === rtrim($path, "/")
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