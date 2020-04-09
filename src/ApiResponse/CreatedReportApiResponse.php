<?php

namespace Silktide\ProspectClient\ApiResponse;

use Psr\Http\Message\ResponseInterface;
use Silktide\ProspectClient\ApiException\ReportAlreadyExistsException;

class CreatedReportApiResponse extends AbstractApiJsonResponse
{
    public function __construct(ResponseInterface $httpResponse)
    {
        switch($httpResponse->getStatusCode()) {
            case 303:
                throw new ReportAlreadyExistsException();
                break;

            case 400:
                break;

            case 422:
                break;
        }
        parent::__construct($httpResponse);
    }

    public function getCreatedId(): string {
        return $this->jsonResponse->{"reportId"};
    }
}