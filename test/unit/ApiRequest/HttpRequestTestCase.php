<?php

namespace Silktide\ProspectClient\UnitTest\ApiRequest;

use GuzzleHttp\Client as GuzzleClient;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Silktide\ProspectClient\Http\HttpWrapper;

class HttpRequestTestCase extends TestCase
{
    public function getMockHttpWrapper(
        string $requestEndpointPath = null,
        string $requestMethod = null,
        array $requestQuery = null,
        array $requestBody = null,
        array $responseJson = [],
        int $responseCode = 200
    ): HttpWrapper {
        $apiKey = uniqid("api-key-");

        $response = self::createMock(ResponseInterface::class);
        $response->method("getBody")
            ->willReturn(json_encode($responseJson));
        $response->method("getStatusCode")
            ->willReturn($responseCode);

        $guzzle = self::createMock(GuzzleClient::class);
        $guzzle->method("request")
            ->willReturn($response);

        /** @var MockObject|HttpWrapper $httpWrapper */
        $httpWrapper = self::getMockBuilder(HttpWrapper::class)
            ->setConstructorArgs([$apiKey, $guzzle])
            ->getMock();

        if ($requestEndpointPath) {
            $httpWrapper->expects(self::once())
                ->method("makeRequest")
                ->with(
                    $requestEndpointPath,
                    $requestMethod,
                    $requestQuery,
                    $requestBody
                )
                ->willReturn($response);
        }

        return $httpWrapper;
    }
}