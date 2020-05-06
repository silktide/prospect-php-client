<?php
namespace Silktide\ProspectClient\ApiRequest;

use Psr\Http\Message\ResponseInterface;
use Silktide\ProspectClient\ApiResponse\AbstractApiResponse;
use Silktide\ProspectClient\Http\HttpWrapper;

abstract class AbstractApiRequest
{
    protected HttpWrapper $httpWrapper;
    protected array $query;
    protected array $body;

    protected string $apiPath = "";
    protected string $apiPathSuffix = "";
    protected string $apiMethod = "get";

    public function __construct(HttpWrapper $httpWrapper)
    {
        $this->httpWrapper = $httpWrapper;
        $this->query = [];
        $this->body = [];
    }

    abstract public function execute(): AbstractApiResponse;

    protected function makeHttpRequest(): ResponseInterface
    {
        return $this->httpWrapper->makeRequest(
            implode("/", [$this->apiPath, $this->apiPathSuffix]),
            strtoupper($this->apiMethod),
            $this->getQueryParameters(),
            $this->getBodyParameters()
        );
    }

    private function getQueryParameters(): ?array
    {
        if (empty($this->query)) {
            return null;
        }

        return $this->query;
    }

    private function getBodyParameters(): ?array
    {
        if (empty($this->body)) {
            return null;
        }

        return $this->body;
    }
}