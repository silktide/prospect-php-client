<?php
require __DIR__ . "/vendor/autoload.php";

use Silktide\ProspectClient\ApiException\ReportStillRunningException;
use Silktide\ProspectClient\ProspectClient;
use Silktide\ProspectClient\ApiRequest\SearchReportApiRequest;

$apiKey = getenv("PROSPECT_API_KEY");
$prospectClient = new ProspectClient($apiKey);

$reportApi = $prospectClient->getReportApi();

$searchResponse = $reportApi->search()
    ->addFilter(
        SearchReportApiRequest::FILTER_PROPERTY_DOMAIN,
        SearchReportApiRequest::FILTER_OPERATOR_EQUAL,
        "twitter.com"
    )
    ->execute();

echo "Found: " . count($searchResponse);

foreach ($searchResponse as $report) {
    var_dump($report->getDomain());
}

$report = $searchResponse->getByIndex(0);
