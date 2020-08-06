<?php
namespace Silktide\ProspectClient\Http;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;
use Silktide\ProspectClient\Request\AbstractRequest;

class HttpWrapper
{
    protected string $scheme = "https";
    protected string $host = "api.prospect.silktide.com";
    protected string $pathVersion = "/api/v1/";

    private string $apiKey;
    private GuzzleClient $guzzle;

    public function __construct(string $apiKey, GuzzleClient $guzzle = null)
    {
        $this->apiKey = $apiKey;
        $this->guzzle = $guzzle ?? new GuzzleClient();
    }

    public function execute(AbstractRequest $request) : HttpResponse
    {
        return $this->makeRequest(
            $request->getMethod(),
            $request->getPath(),
            $request->getQueryParams(),
            $request->getBody()
        );
    }

    public function setHost(string $host) : void
    {
        $this->host = $host;
    }

    private function makeRequest(string $method = "get", string $path = "", array $query = [], array $body = []) : HttpResponse
    {
        $uri = (new Uri())
            ->withScheme($this->scheme)
            ->withHost($this->host)
            ->withPath($this->pathVersion . $path);

        $uri = (string)$uri;

        $options = [
            RequestOptions::HEADERS => [
                "api-key" => $this->apiKey,
                "content-type" => "application/json",
            ],
            RequestOptions::QUERY => $query,
            RequestOptions::HTTP_ERRORS => false
        ];

        if (count($body) > 0) {
            $options[RequestOptions::BODY] = json_encode($body);
        }

        return new HttpResponse(
            $this->guzzle->request(
                strtoupper($method),
                trim($uri, "/"),
                $options
            )
        );
    }
}