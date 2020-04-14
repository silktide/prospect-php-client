<?php

namespace Silktide\ProspectClient\Api;

use Silktide\ProspectClient\Api\Fields\ReportApiFields;
use Silktide\ProspectClient\ApiResponse\CreatedReportApiResponse;
use Silktide\ProspectClient\ApiResponse\ExistingReportApiResponse;
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

    public function create(
        string $siteUrl,
        ReportApiFields $fields = null
    ):CreatedReportApiResponse
    {
        $body = new BodyData();
        $body->set("url", $siteUrl);

        if($fields) {
            $body->setFields($fields);
        }

        $httpResponse = $this->callApi(
            "/",
            "POST",
            null,
            $body
        );

        return new CreatedReportApiResponse($httpResponse);
    }

    public function reanalyze(
        $reportId
    ):ExistingReportApiResponse
    {
        $httpResponse = $this->callApi(
            $reportId,
            "POST"
        );

        return new ExistingReportApiResponse($httpResponse);
    }
}