<?php

namespace Silktide\ProspectClient\Api;

use Silktide\ProspectClient\Request\CreateReportRequest;
use Silktide\ProspectClient\Request\FetchReportRequest;
use Silktide\ProspectClient\Request\ReanalyzeReportRequest;
use Silktide\ProspectClient\Request\SearchReportRequest;
use Silktide\ProspectClient\Entity\Report;
use Silktide\ProspectClient\Http\HttpWrapper;

class ReportApi
{
    protected HttpWrapper $httpWrapper;

    public function __construct(HttpWrapper $httpWrapper)
    {
        $this->httpWrapper = $httpWrapper;
    }

    public function create(): CreateReportRequest
    {
        return new CreateReportRequest($this->httpWrapper);
    }

    public function fetch(string $reportId): FetchReportRequest
    {
        return new FetchReportRequest($this->httpWrapper, $reportId);
    }

    public function reanalyze(string $reportId): ReanalyzeReportRequest
    {
        return new ReanalyzeReportRequest($this->httpWrapper, $reportId);
    }

    public function search(): SearchReportRequest
    {
        return new SearchReportRequest($this->httpWrapper);
    }
}