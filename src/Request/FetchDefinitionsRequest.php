<?php

namespace Silktide\ProspectClient\Request;

use Silktide\ProspectClient\Exception\Api\DefinitionsNotFoundException;
use Silktide\ProspectClient\Response\FetchDefinitionsResponse;

class FetchDefinitionsRequest extends AbstractRequest
{
    protected string $path = 'fetch-definitions';
    protected array $queryParams = [];

    public function getPath(): string
    {
        return $this->path;
    }

    public function execute(): FetchDefinitionsResponse
    {
        $httpResponse = $this->httpWrapper->execute($this);

        if ($httpResponse->getStatusCode() === 404) {
            throw new DefinitionsNotFoundException($response['error_message'] ?? 'Endpoint not found');
        }

        return new FetchDefinitionsResponse($httpResponse->getResponse());
    }
}
