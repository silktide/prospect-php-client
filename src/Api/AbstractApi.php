<?php

namespace Silktide\ProspectClient\Api;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\ResponseInterface as HttpResponse;
use Silktide\ProspectClient\Data\BodyData;
use Silktide\ProspectClient\Data\QueryStringData;

abstract class AbstractApi
{
    const API_SCHEME = "https";
    const API_HOST = "api.prospect.silktide.com";
    const API_PATH_VERSION = "/api/v1";
    const API_PATH_PREFIX = "";

    private string $apiKey;
    private HttpClient $httpClient;

    public function __construct(string $apiKey, HttpClient $httpClient = null)
    {
        $this->apiKey = $apiKey;
        $this->httpClient = $httpClient ?? new HttpClient();
    }

    protected function callApi(
        string $path,
        string $method = "get",
        QueryStringData $query = null,
        BodyData $body = null
    ): HttpResponse {
        $uri = (new Uri())
            ->withScheme(self::API_SCHEME)
            ->withHost(self::API_HOST)
            ->withPath(
                implode("/", [
                    static::API_PATH_VERSION,
                    static::API_PATH_PREFIX,
                    $path,
                ])
            );

        if($query) {
            $uri = $uri->withQuery($query);
        }

        $options = [
            "headers" => [
                "api-key" => $this->apiKey,
                "content-type" => "application/json",
            ]
        ];

        if($body) {
            $options["body"] = $body;
        }

        return $this->httpClient->request(
            strtoupper($method),
            $uri,
            $options
        );
    }
}