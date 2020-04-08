<?php

namespace Silktide\ProspectClient\Api;

use Silktide\ProspectClient\ApiResponse\ReportApiResponse;

class ReportApi extends AbstractApi
{
    const API_PATH_PREFIX = "report";

    public function fetch(int $reportId):ReportApiResponse
    {
        $httpResponse = $this->callApi($reportId);
        return new ReportApiResponse($httpResponse);
    }
}