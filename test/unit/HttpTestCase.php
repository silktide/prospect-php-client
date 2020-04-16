<?php

namespace Silktide\ProspectClient\UnitTest;

use GuzzleHttp\Client as HttpClient;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use Prophecy\Exception\Prediction\PredictionException;
use Prophecy\Prophecy\MethodProphecy;
use Prophecy\Prophecy\ObjectProphecy;
use Prophecy\Prophet;
use function GuzzleHttp\json_encode;

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
        array $responseBodyJsonFields = null,
        int $responseStatusCode = 200
    ): HttpClient {
        $expectedBody = null;
        if ($requestBodyJsonFields) {
            $expectedBody = json_encode($requestBodyJsonFields);
        }

        $mockResponse = self::createMock(ResponseInterface::class);

        if (!is_null($responseBodyJsonFields)) {
            $bodyString = json_encode((object)$responseBodyJsonFields);
            $mockResponse->method("getBody")
                ->willReturn($bodyString);
        }

        $mockResponse->method("getStatusCode")
            ->willReturn($responseStatusCode);

        $mockClient = self::createMock(HttpClient::class);
        $mockClient->method("request")
            ->with(
// 0. First parameter is the upper case request method.
                strtoupper($expectedMethod),
// 1. Second parameter is a UriInterface with expected host and path.
                self::callback(
                    fn(UriInterface $uri) => $uri->getHost() === $expectedHost
                        && rtrim($uri->getPath(), "/") === rtrim($expectedPath, "/")
                ),
// 2. Third parameter is the options array. It must have the API key, but has an optional body.
                self::callback(
                    fn(array $array) => (
                            isset($array["headers"])
                            && isset($array["headers"]["api-key"])
                            && $array["headers"]["api-key"] === $expectedApiKey
                        ) && (
                            empty($expectedBody) || (
                                isset($array["body"])
                                && $array["body"] == $expectedBody
                            )
                        )
                )
            )
            ->willReturn($mockResponse);

        return $mockClient;
    }

    /**
     * Returns a mock iterator for the specified class.
     *
     * @param string|string[] $originalClassName
     *
     * @psalm-template RealInstanceType of object
     * @psalm-param class-string<RealInstanceType>|string[] $originalClassName
     * @psalm-return MockObject&RealInstanceType
     */
    protected function createMockIterator($originalClassName, array $data): MockObject
    {
        $mock = $this->createMock($originalClassName);
        $counter = 0;

        $mock
            ->expects($this->at($counter))
            ->method('rewind');

        foreach ($data as $key => $value) {
            $mock
                ->expects($this->at(++$counter))
                ->method("valid")
                ->will($this->returnValue(true));

            $mock
                ->expects($this->at(++$counter))
                ->method("current")
                ->will($this->returnValue($value));

            $mock
                ->expects($this->at(++$counter))
                ->method("key")
                ->will($this->returnValue($key));

            $mock
                ->expects($this->at(++$counter))
                ->method("next");
        }

        $mock
            ->expects($this->at(++$counter))
            ->method("valid")
            ->will($this->returnValue(false));

        return $mock;
    }
}