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

    public function __construct(array $response)
    {
        $this->response = $response;
    }

    public function getRequestStatus() : string
    {
        return $this->response['status'] ?? 'unknown';
    }
}