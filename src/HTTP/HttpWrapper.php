<?php


namespace Silktide\ProspectClient\HTTP;


use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\ResponseInterface as HttpResponse;
use Silktide\ProspectClient\Data\BodyData;
use Silktide\ProspectClient\Data\QueryStringData;

class HttpWrapper
{
    const API_SCHEME = "https";
    const API_HOST = "api.prospect.silktide.com";
    const API_PATH_VERSION = "/api/v1";

    protected $client;
    protected $apiKey;

    public function __construct(Client $client, string $apiKey)
    {
        $this->client = $client;
        $this->apiKey = $apiKey;
    }

    public function execute(
        string $path = "/",
        string $method = "get",
        array $query = null,
        array $body = null
    ): HttpResponse {

        $uri = (new Uri())
            ->withScheme(self::API_SCHEME)
            ->withHost(self::API_HOST)
            ->withPath(
                implode("/", [
                    static::API_PATH_VERSION,
                    ($path === "/" ? "" : $path),
                ])
            );

        if($query !== null) {
            $uri = $uri->withQuery(http_build_query($query));
        }

        $options = [
            "headers" => [
                "api-key" => $this->apiKey,
                "content-type" => "application/json",
            ]
        ];

        if($body !== null && count($body) > 0) {
            $options["body"] = json_encode($body);;
        }

        return $this->client->request(
            strtoupper($method),
            $uri,
            $options
        );
    }
}