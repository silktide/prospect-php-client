<?php

namespace Silktide\ProspectClient\ApiResponse;

use Psr\Http\Message\ResponseInterface;
use Silktide\ProspectClient\ApiException\ReportAlreadyExistsException;
use Silktide\ProspectClient\ApiException\ReportNotFoundException;
use Silktide\ProspectClient\ApiException\ReportPathDoesNotExistException;
use Silktide\ProspectClient\ApiException\ReportPathUnprocessableException;

class ReportApiResponse extends AbstractApiJsonResponse
{
    public function __construct(ResponseInterface $httpResponse)
    {
        switch($httpResponse->getStatusCode()) {
            case 303:
                throw new ReportAlreadyExistsException();
                break;

            case 400:
                throw new ReportPathUnprocessableException();
                break;

            case 404:
                throw new ReportNotFoundException();
                break;

            case 422:
                throw new ReportPathDoesNotExistException();
                break;
        }
        parent::__construct($httpResponse);
    }

    public function getReportId(): string {
        return $this->jsonResponse->{"reportId"};
    }
}