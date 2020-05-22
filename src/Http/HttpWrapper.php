<?php
namespace Silktide\ProspectClient\Http;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\ResponseInterface;

class HttpWrapper
{
    const API_SCHEME = "https";
    const API_HOST = "api.prospect.silktide.com";
    const API_PATH_VERSION = "/api/v1";

    /** @var string */
    private $apiKey;
    /** @var GuzzleClient */
    private $guzzle;

    public function __construct(string $apiKey, GuzzleClient $guzzle = null)
    {
        $this->apiKey = $apiKey;
        $this->guzzle = $guzzle ?? new GuzzleClient();
    }

    public function makeRequest(
        string $endpointPath = "/",
        string $method = "get",
        ?array $query = null,
        ?array $body = null
    ):ResponseInterface
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

        if(!empty($query)) {
            $queryString = "";

            foreach($query as $key => $value) {
                if($queryString) {
                    $queryString .= "&";
                }

                $queryString .= "$key=$value";
            }

            $uri = $uri . "?$queryString";
        }

        $options = [
            "headers" => [
                "api-key" => $this->apiKey,
                "content-type" => "application/json",
            ]
        ];

        if(!empty($body)) {
            $options["body"] = json_encode($body);
        }

        return $this->guzzle->request(
            strtoupper($method),
            trim($uri, "/"),
            $options
        );
    }
}