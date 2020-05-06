<?php
namespace Silktide\ProspectClient\ApiRequest;

use Psr\Http\Message\ResponseInterface;
use Silktide\ProspectClient\ApiResponse\AbstractApiResponse;
use Silktide\ProspectClient\Http\HttpWrapper;

abstract class AbstractApiRequest
{
    /** @var HttpWrapper */
    protected $httpWrapper;
    /** @var array */
    protected $query;
    /** @var array */
    protected $body;

    /** @var string */
    protected $apiPath = "";
    /** @var string */
    protected $apiPathSuffix = "";
    /** @var string */
    protected $apiMethod = "get";

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