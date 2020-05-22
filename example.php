<?php
require __DIR__ . "/vendor/autoload.php";

use Silktide\ProspectClient\ApiException\ReportStillRunningException;
use Silktide\ProspectClient\ProspectClient;
use Silktide\ProspectClient\ApiRequest\SearchReportApiRequest;

$host = "bbc.co.uk";

$apiKey = getenv("PROSPECT_API_KEY");
$prospectClient = new ProspectClient($apiKey);
$reportApi = $prospectClient->getReportApi();

$createResponse = $reportApi->create()
    ->setUrl("https://www.$host")
    ->setCustomField("nibblerHostname", $host)
    ->setName("BBC")
    ->execute();

$createdId = $createResponse->getReportId();
echo "Created ID: " . $createdId . PHP_EOL;

$searchResponse = $reportApi->search()
    ->addFilter(
        SearchReportApiRequest::FILTER_PROPERTY_DOMAIN,
        SearchReportApiRequest::FILTER_OPERATOR_EQUAL,
        $host
    )
    ->execute();

$report = $searchResponse->getByIndex(0);

if($report) {
    echo "Got the report as you'd expect: " . $report->getId() . PHP_EOL;
}
else {
    echo "Not got the report using normal search." . PHP_EOL;
}

$searchResponse = $reportApi->search()
    ->addFilter(
        SearchReportApiRequest::FILTER_PROPERTY_DOMAIN,
        SearchReportApiRequest::FILTER_OPERATOR_STR_CONTAINS,
        $host
    )
    ->execute();

$report = $searchResponse->getByIndex(0);

if($report) {
    echo "Got the report with str_contains: " . $report->getId() . PHP_EOL;
}
else {
    echo "Not got the report using str_contains." . PHP_EOL;
}

//$searchResponse = $reportApi->search()
//    ->addFilter(
//        "nibbler.domain"
//    )