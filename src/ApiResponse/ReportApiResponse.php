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
        switch ($httpResponse->getStatusCode()) {
            case 303:
                $body = json_decode($httpResponse->getBody()->getContents(), true);
                $exception = new ReportAlreadyExistsException();
                $exception->setReportId($body['reportId']);
                $exception->setResolvedUrl($body['resolved_url'] ?? null);

                throw $exception;

            case 400:
                throw new ReportPathUnprocessableException();

            case 404:
                throw new ReportNotFoundException();

            case 422:
                throw new ReportPathDoesNotExistException();
        }
        parent::__construct($httpResponse);
    }

    public function getReportId(): string
    {
        return $this->jsonResponse["reportId"] ?? $this->jsonResponse["report"]["report_id"];
    }

    public function getStatus(): ?string
    {
        return $this->jsonResponse["status"] ?? null;
    }

    public function getReportStatus(): ?string
    {
        return $this->jsonResponse["report_status"] ?? null;
    }
}