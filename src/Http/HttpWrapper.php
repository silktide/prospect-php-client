<?php
namespace Silktide\ProspectClient\Http;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\ResponseInterface;
use Silktide\ProspectClient\Request\AbstractRequest;

class HttpWrapper
{
    const API_SCHEME = "https";
    const API_HOST = "api.prospect.silktide.com";
    const API_PATH_VERSION = "/api/v1";

    private string $apiKey;
    private GuzzleClient $guzzle;

    public function __construct(string $apiKey, GuzzleClient $guzzle = null)
    {
        $this->apiKey = $apiKey;
        $this->guzzle = $guzzle ?? new GuzzleClient();
    }

    public function execute(AbstractRequest $request) : ResponseInterface
    {
        return $this->makeRequest(
            $request->getPath(),
            $request->getMethod(),
            $request->getQueryParams(),
            $request->getBody()
        );
    }

    private function makeRequest(string $endpointPath = "/", string $method = "get", array $query = [], array $body = []) : ResponseInterface
    {
        $uri = (new Uri())
            ->withScheme(self::API_SCHEME)
            ->withHost(self::API_HOST)
            ->withPath(
                implode("/", [
                    static::API_PATH_VERSION,
                    ($endpointPath === "/" ? "" : $endpointPath),
                ])
            );

        $uri = (string)$uri;

        $options = [
            "headers" => [
                "api-key" => $this->apiKey,
                "content-type" => "application/json",
            ],
            "query" => $query
        ];

        if (count($body) > 0) {
            $options["body"] = json_encode($body);
        }

        return $this->guzzle->request(
            strtoupper($method),
            trim($uri, "/"),
            $options
        );
    }
}