<?php

namespace Silktide\ProspectClient\Api;

use Silktide\ProspectClient\ApiRequest\CreateReportApiRequest;
use Silktide\ProspectClient\ApiRequest\FetchReportApiRequest;
use Silktide\ProspectClient\ApiRequest\ReanalyzeReportApiRequest;
use Silktide\ProspectClient\ApiRequest\SearchReportApiRequest;
use Silktide\ProspectClient\Entity\Report;

class ReportApi extends AbstractApi
{
    public function create(): CreateReportApiRequest
    {
        return new CreateReportApiRequest($this->httpWrapper);
    }

    public function reanalyze(): ReanalyzeReportApiRequest
    {
        return new ReanalyzeReportApiRequest($this->httpWrapper);
    }

    public function search(): SearchReportApiRequest
    {
        return new SearchReportApiRequest($this->httpWrapper);
    }

    public function fetch(): FetchReportApiRequest
    {
        return new FetchReportApiRequest($this->httpWrapper);
    }
}