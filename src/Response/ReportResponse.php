<?php

namespace Silktide\ProspectClient\Response;

use Psr\Http\Message\ResponseInterface;
use Silktide\ProspectClient\Exception\Api\ReportAlreadyExistsException;
use Silktide\ProspectClient\Exception\Api\ReportNotFoundException;
use Silktide\ProspectClient\Exception\Api\ReportPathDoesNotExistException;
use Silktide\ProspectClient\Exception\Api\ReportPathUnprocessableException;

class ReportResponse extends AbstractResponse
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
        return $this->response["reportId"] ?? $this->response["report"]["report_id"];
    }

    public function getStatus(): ?string
    {
        return $this->response["status"] ?? null;
    }

    public function getReportStatus(): ?string
    {
        return $this->response["report_status"] ?? null;
    }
}