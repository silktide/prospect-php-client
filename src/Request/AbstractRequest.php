<?php

namespace Silktide\ProspectClient\Request;

use Silktide\ProspectClient\Http\HttpWrapper;
use Silktide\ProspectClient\Response\AbstractResponse;

abstract class AbstractRequest
{
    protected string $method = "get";
    protected string $path = "";

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

    public function getBody() : array
    {
        return $this->body;
    }

    abstract public function execute() : AbstractResponse;
}
