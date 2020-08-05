<?php

namespace Silktide\ProspectClient\Exception\Api;

use Silktide\ProspectClient\Exception\ProspectClientException;

class ReportAlreadyExistsException extends ProspectClientException
{

    /**
     * @var string
     */
    protected $reportId;

    /**
     * @var string|null
     */
    protected $resolvedUrl;

    /**
     * @return string
     */
    public function getReportId(): string
    {
        return $this->reportId;
    }

    /**
     * @param string $reportId
     */
    public function setReportId(string $reportId): void
    {
        $this->reportId = $reportId;
    }

    /**
     * @return string|null
     */
    public function getResolvedUrl(): ?string
    {
        return $this->resolvedUrl;
    }

    /**
     * @param string|null $resolvedUrl
     */
    public function setResolvedUrl(?string $resolvedUrl): void
    {
        $this->resolvedUrl = $resolvedUrl;
    }


}