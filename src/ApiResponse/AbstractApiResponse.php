<?php

namespace Silktide\ProspectClient\ApiResponse;

use Psr\Http\Message\ResponseInterface;

abstract class AbstractApiResponse
{
    /** @var array */
    protected $body;

    public function __construct(ResponseInterface $httpResponse)
    {
        $body = $httpResponse->getBody();
        $this->body = \GuzzleHttp\json_decode($body, true);
    }
}