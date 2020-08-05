<?php

namespace Silktide\ProspectClient\Response;

use Psr\Http\Message\ResponseInterface;
use function GuzzleHttp\json_decode;

abstract class AbstractResponse
{
    protected ResponseInterface $httpResponse;

    /**
     * @var array<mixed>
     */
    protected array $response = [];

    public function __construct(ResponseInterface $httpResponse)
    {
        $this->httpResponse = $httpResponse;
        $this->response = json_decode($httpResponse->getBody()->getContents(), true);
    }
}