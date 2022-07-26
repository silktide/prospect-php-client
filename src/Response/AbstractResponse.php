<?php

namespace Silktide\ProspectClient\Response;

abstract class AbstractResponse
{
    /**
     * @var array
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
        return $this->response['request_status'] ?? null;
    }
}
