<?php
namespace Silktide\ProspectClient\Request;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Silktide\ProspectClient\Http\HttpWrapper;
use Silktide\ProspectClient\Response\AbstractResponse;

abstract class AbstractRequest
{
    protected string $method = "get";
    protected string $path = "";

    /**
     * @var array<string,string>
     */
    protected array $queryParams = [];
    protected array $body = [];

    protected HttpWrapper $httpWrapper;

    public function __construct(HttpWrapper $httpWrapper)
    {
        $this->httpWrapper = $httpWrapper;
    }

    public function getMethod() : string
    {
        return $this->method;
    }

    public function getPath() : string
    {
        return $this->path;
    }

    public function getQueryParams() : array
    {
        return $this->queryParams;
    }

    public function getBody()
    {
        return $this->body;
    }

    abstract public function execute() : AbstractResponse;

    private function run() : ResponseInterface
    {
        return $this->httpWrapper->execute($this);
    }
}