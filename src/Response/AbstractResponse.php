<?php

namespace Silktide\ProspectClient\Response;

abstract class AbstractResponse
{
    protected array $response = [];

    public function __construct(array $response)
    {
        $this->response = $response;
    }

    public function getRequestStatus() : ?string
    {
        return $this->response['request_status'] ?? null;
    }
}
