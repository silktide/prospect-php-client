<?php

namespace Silktide\ProspectClient\Api;

use Silktide\ProspectClient\Request\CreateReportRequest;
use Silktide\ProspectClient\Request\FetchDefinitionsRequest;
use Silktide\ProspectClient\Request\FetchReportRequest;
use Silktide\ProspectClient\Request\ReanalyzeReportRequest;
use Silktide\ProspectClient\Request\ReportSettingsRequest;
use Silktide\ProspectClient\Request\ReportSpellingsRequest;
use Silktide\ProspectClient\Request\SearchReportRequest;
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

    public function fetchDefinitions(): FetchDefinitionsRequest
    {
        return new FetchDefinitionsRequest($this->httpWrapper);
    }

    public function reanalyze(string $reportId): ReanalyzeReportRequest
    {
        return new ReanalyzeReportRequest($this->httpWrapper, $reportId);
    }

    public function search(): SearchReportRequest
    {
        return new SearchReportRequest($this->httpWrapper);
    }

    public function settings(string $reportId)
    {
        return new ReportSettingsRequest($this->httpWrapper, $reportId);
    }

    public function spellings(string $reportId)
    {
        return new ReportSpellingsRequest($this->httpWrapper, $reportId);
    }
}
