<?php

namespace Silktide\ProspectClient\ApiException;

use Silktide\ProspectClient\ProspectClientException;

class ReportAlreadyExistsException extends ProspectClientException {

    /**
     * @var string
     */
    protected $reportId;

    /**
     * @var string
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
     * @return string
     */
    public function getResolvedUrl(): string
    {
        return $this->resolvedUrl;
    }

    /**
     * @param string $resolvedUrl
     */
    public function setResolvedUrl(string $resolvedUrl): void
    {
        $this->resolvedUrl = $resolvedUrl;
    }

}