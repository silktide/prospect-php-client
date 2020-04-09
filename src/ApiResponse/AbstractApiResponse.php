<?php

namespace Silktide\ProspectClient\ApiResponse;

use Psr\Http\Message\ResponseInterface;

abstract class AbstractApiResponse
{
    public function __construct(ResponseInterface $httpResponse)
    {
    }
}