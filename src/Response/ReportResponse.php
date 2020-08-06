<?php

namespace Silktide\ProspectClient\Response;

use Psr\Http\Message\ResponseInterface;
use Silktide\ProspectClient\Exception\Api\ReportAlreadyExistsException;
use Silktide\ProspectClient\Exception\Api\ReportNotFoundException;
use Silktide\ProspectClient\Exception\Api\ReportPathDoesNotExistException;
use Silktide\ProspectClient\Exception\Api\ReportUnprocessableException;

class ReportResponse extends AbstractResponse
{
    public function getReportId(): string
    {
        // When doing fetch, it's on the report["report_id"]
        return $this->response["reportId"] ?? $this->response["report"]["report_id"];
    }

    public function getReportStatus(): ?string
    {
        return $this->response["report_status"] ?? null;
    }
}