<?php

namespace Silktide\ProspectClient\Exception\Api;

use Silktide\ProspectClient\Exception\ProspectClientException;

class ReportAlreadyExistsException extends ProspectClientException
{
    protected string $reportId;
    protected ?string $resolvedUrl;

    public function getReportId(): string
    {
        return $this->reportId;
    }

    public function setReportId(string $reportId): void
    {
        $this->reportId = $reportId;
    }

    public function getResolvedUrl(): ?string
    {
        return $this->resolvedUrl;
    }

    public function setResolvedUrl(?string $resolvedUrl): void
    {
        $this->resolvedUrl = $resolvedUrl;
    }
}
