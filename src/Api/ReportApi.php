<?php

namespace Silktide\ProspectClient\Api;

use Silktide\ProspectClient\Api\Fields\ReportApiFields;
use Silktide\ProspectClient\Api\Filter\ReportApiFilter;
use Silktide\ProspectClient\ApiException\ReportNotFoundException;
use Silktide\ProspectClient\ApiException\ReportStillRunningException;
use Silktide\ProspectClient\ApiRequest\CreateReportApiRequest;
use Silktide\ProspectClient\ApiRequest\FetchReportApiRequest;
use Silktide\ProspectClient\ApiRequest\ReanalyzeReportApiRequest;
use Silktide\ProspectClient\ApiRequest\SearchReportApiRequest;
use Silktide\ProspectClient\ApiResponse\CreateReportApiResponse;
use Silktide\ProspectClient\ApiResponse\ExistingReportApiResponse;
use Silktide\ProspectClient\ApiResponse\FetchReportApiResponse;
use Silktide\ProspectClient\ApiResponse\ListReportApiResponse;
use Silktide\ProspectClient\ApiResponse\ReportApiResponse;
use Silktide\ProspectClient\Data\BodyData;
use Silktide\ProspectClient\Entity\Report;

class ReportApi extends AbstractApi
{
    public function create():CreateReportApiRequest
    {
        return new CreateReportApiRequest($this->httpWrapper);
    }

    public function reanalyze():ReanalyzeReportApiRequest
    {
        return new ReanalyzeReportApiRequest($this->httpWrapper);
    }

    public function search():SearchReportApiRequest
    {
        return new SearchReportApiRequest($this->httpWrapper);
    }

    public function fetch(string $reportId): Report
    {
        $request = new FetchReportApiRequest($this->httpWrapper);
        $request->setId($reportId);
        $response = $request->execute();
        return $response->getReport();
    }
}