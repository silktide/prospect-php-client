<?php

namespace Silktide\ProspectClient\UnitTest\Http;

use GuzzleHttp\Client as GuzzleClient;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Silktide\ProspectClient\Http\HttpWrapper;

class HttpWrapperTest extends TestCase
{
    public function testMakeRequest() {
        $apiKey = uniqid("apikey-");

        $uri = HttpWrapper::API_SCHEME . "://"
            . HttpWrapper::API_HOST
            . HttpWrapper::API_PATH_VERSION;
        $options = [
            "headers" => [
                "api-key" => $apiKey,
                "content-type" => "application/json",
            ]
        ];
        $response = self::createMock(ResponseInterface::class);
        $guzzle = self::createMock(GuzzleClient::class);
        $guzzle->expects(self::once())
            ->method("request")
            ->with("GET", $uri, $options)
            ->willReturn($response);

        $sut = new HttpWrapper($apiKey, $guzzle);
        $sut->makeRequest();
    }

    public function testMakeRequestEndpoint() {
        $apiKey = uniqid("apikey-");
        $endpoint = uniqid("endpoint-");

        $baseUri = HttpWrapper::API_SCHEME . "://"
            . HttpWrapper::API_HOST
            . HttpWrapper::API_PATH_VERSION;
        $options = [
            "headers" => [
                "api-key" => $apiKey,
                "content-type" => "application/json",
            ]
        ];
        $response = self::createMock(ResponseInterface::class);
        $guzzle = self::createMock(GuzzleClient::class);
        $guzzle->expects(self::once())
            ->method("request")
            ->with("GET", implode("/", [$baseUri, $endpoint]), $options)
            ->willReturn($response);

        $sut = new HttpWrapper($apiKey, $guzzle);
        $sut->makeRequest($endpoint);
    }

    public function testMakeRequestMethod() {
        $apiKey = uniqid("apikey-");
        $endpoint = "/";

        $baseUri = HttpWrapper::API_SCHEME . "://"
            . HttpWrapper::API_HOST
            . HttpWrapper::API_PATH_VERSION;
        $options = [
            "headers" => [
                "api-key" => $apiKey,
                "content-type" => "application/json",
            ]
        ];
        $response = self::createMock(ResponseInterface::class);
        $guzzle = self::createMock(GuzzleClient::class);
        $guzzle->expects(self::once())
            ->method("request")
            ->with("POST", trim($baseUri . $endpoint, "/"), $options)
            ->willReturn($response);

        $sut = new HttpWrapper($apiKey, $guzzle);
        $sut->makeRequest($endpoint, "post");
    }

    public function testMakeRequestQuery() {
        $apiKey = uniqid("apikey-");
        $endpoint = "/";
        $query = [
            "key1" => "value1",
            "key2" => "value2",
        ];
        $queryString = http_build_query($query);

        $baseUri = HttpWrapper::API_SCHEME . "://"
            . HttpWrapper::API_HOST
            . HttpWrapper::API_PATH_VERSION;
        $options = [
            "headers" => [
                "api-key" => $apiKey,
                "content-type" => "application/json",
            ]
        ];
        $response = self::createMock(ResponseInterface::class);
        $guzzle = self::createMock(GuzzleClient::class);
        $guzzle->expects(self::once())
            ->method("request")
            ->with("GET", $baseUri . $endpoint . "?$queryString", $options)
            ->willReturn($response);

        $sut = new HttpWrapper($apiKey, $guzzle);

        $sut->makeRequest($endpoint, "get", $query);
    }

    public function testMakeRequestBody() {
        $apiKey = uniqid("apikey-");
        $endpoint = "/";
        $query = [];
        $body = [
            "key1" => "value1",
            "key2" => "value2",
        ];
        $bodyString = urlencode(json_encode($body));

        $baseUri = HttpWrapper::API_SCHEME . "://"
            . HttpWrapper::API_HOST
            . HttpWrapper::API_PATH_VERSION;
        $options = [
            "headers" => [
                "api-key" => $apiKey,
                "content-type" => "application/json",
            ],
            "body" => $bodyString,
        ];
        $response = self::createMock(ResponseInterface::class);
        $guzzle = self::createMock(GuzzleClient::class);
        $guzzle->expects(self::once())
            ->method("request")
            ->with("GET", trim($baseUri . $endpoint, "/"), $options)
            ->willReturn($response);

        $sut = new HttpWrapper($apiKey, $guzzle);

        $sut->makeRequest($endpoint, "get", $query, $body);
    }
}