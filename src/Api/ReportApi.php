<?php

namespace Silktide\ProspectClient\Api;

use Silktide\ProspectClient\Api\Fields\ReportApiFields;
use Silktide\ProspectClient\Api\Filter\ReportApiFilter;
use Silktide\ProspectClient\ApiException\ReportNotFoundException;
use Silktide\ProspectClient\ApiException\ReportStillRunningException;
use Silktide\ProspectClient\ApiResponse\CreatedReportApiResponse;
use Silktide\ProspectClient\ApiResponse\ExistingReportApiResponse;
use Silktide\ProspectClient\ApiResponse\ListReportApiResponse;
use Silktide\ProspectClient\ApiResponse\ReportApiResponse;
use Silktide\ProspectClient\Data\BodyData;

class ReportApi extends AbstractApi
{
    const API_PATH_PREFIX_SINGLE_REPORT = "report";
    const API_PATH_PREFIX_LIST_REPORTS = "reports";

    public function fetch(string $reportId):ReportApiResponse
    {
        $httpResponse = $this->callApi(implode("/", [
            self::API_PATH_PREFIX_SINGLE_REPORT,
            $reportId,
        ]));

        switch($httpResponse->getStatusCode()) {
            case 202:
                throw new ReportStillRunningException($reportId);
                break;
        }

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
            self::API_PATH_PREFIX_SINGLE_REPORT,
            "POST",
            null,
            $body
        );

        return new CreatedReportApiResponse($httpResponse);
    }

    public function reanalyze(
        $reportId,
        ReportApiFields $fields = null
    ):ExistingReportApiResponse
    {
        $body = null;

        if($fields) {
            $body = new BodyData();
            $body->setFields($fields);
        }

        $httpResponse = $this->callApi(
            implode("/", [
                self::API_PATH_PREFIX_SINGLE_REPORT,
                $reportId,
            ]),
            "POST",
            null,
            $body
        );

        return new ExistingReportApiResponse($httpResponse);
    }

    public function search(
        ReportApiFilter $filter = null
    ):ListReportApiResponse
    {
        $queryStringData = null;
        if($filter) {
            $queryStringData = $filter->asQueryStringData();
        }

        $httpResponse = $this->callApi(
            self::API_PATH_PREFIX_LIST_REPORTS,
            "GET",
            $queryStringData
        );

        return new ListReportApiResponse($httpResponse);
    }
}