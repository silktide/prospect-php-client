<?php

namespace Silktide\ProspectClient\ApiResponse;

use Psr\Http\Message\ResponseInterface;

abstract class AbstractApiResponse
{
    protected array $body;

    public function __construct(ResponseInterface $httpResponse)
    {
        $this->body = \GuzzleHttp\json_decode($httpResponse->getBody(), true);
    }
}