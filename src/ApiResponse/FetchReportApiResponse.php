<?php

namespace Silktide\ProspectClient\ApiResponse;

use Silktide\ProspectClient\Entity\Report;

class FetchReportApiResponse extends ReportApiResponse
{
    public function getReport(): Report
    {
        return new Report($this->jsonResponse["report"]);
    }
}