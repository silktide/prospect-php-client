<?php

namespace Silktide\ProspectClient\Api;

use Silktide\ProspectClient\ApiResponse\ReportApiResponse;

class ReportApi extends AbstractApi
{
    const API_SUFFIX = "/report";

    public function fetch(int $reportId):ReportApiResponse
    {
//        $this->callApi($reportId);
        return new ReportApiResponse();
    }
}