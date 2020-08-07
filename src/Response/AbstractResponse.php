<?php

namespace Silktide\ProspectClient\Response;

use Psr\Http\Message\ResponseInterface;
use function GuzzleHttp\json_decode;

abstract class AbstractResponse
{
    /**
     * @var array<mixed>
     */
    protected array $response = [];

    public function __construct(array $response)
    {
        $this->response = $response;
    }

    /**
     * @return string|null
     */
    public function getRequestStatus() : ?string
    {
        return $this->response['requestStatus'] ?? null;
    }
}