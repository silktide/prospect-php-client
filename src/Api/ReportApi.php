<?php

namespace Silktide\ProspectClient\Api;

use Silktide\ProspectClient\ApiResponse\CreatedReportApiResponse;
use Silktide\ProspectClient\ApiResponse\ReportApiResponse;
use Silktide\ProspectClient\Data\BodyData;

class ReportApi extends AbstractApi
{
    const API_PATH_PREFIX = "report";

    public function fetch(int $reportId):ReportApiResponse
    {
        $httpResponse = $this->callApi($reportId);
        return new ReportApiResponse($httpResponse);
    }

    public function create(string $siteUrl):CreatedReportApiResponse
    {
        $body = new BodyData();
        $body->set("url", $siteUrl);

        $httpResponse = $this->callApi(
            "/",
            "POST",
            null,
            $body
        );

        return new CreatedReportApiResponse($httpResponse);
    }
}