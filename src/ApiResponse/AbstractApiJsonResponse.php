<?php

namespace Silktide\ProspectClient\ApiResponse;

use Psr\Http\Message\ResponseInterface;
use function GuzzleHttp\json_decode;

class AbstractApiJsonResponse extends AbstractApiResponse
{
    /** @var object|array|null */
    protected $jsonResponse;

    public function __construct(ResponseInterface $httpResponse)
    {
        parent::__construct($httpResponse);
        $body = $httpResponse->getBody();

        $this->jsonResponse = null;
        if (!is_null($body)) {
            $this->jsonResponse = json_decode($body, true);
        }
    }
}