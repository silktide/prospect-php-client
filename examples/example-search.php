<?php
require __DIR__ . "/../vendor/autoload.php";

use Symfony\Component\Dotenv\Dotenv;
use Silktide\ProspectClient\ProspectClient;
use Silktide\ProspectClient\Request\SearchReportRequest;

$envFile = __DIR__ . "/../.env";
if (file_exists($envFile)) {
    (new Dotenv())->load($envFile);
}
$apiKey = $_ENV["PROSPECT_API_KEY"] ?? null;

if (!is_string($apiKey)) {
    throw new \Exception("An API key should be specified in the ./env file to run the examples");
}

$prospectClient = new ProspectClient($apiKey);
$reportApi = $prospectClient->getReportApi();

$searchResponse = $reportApi->search()
    ->addFilter(
        SearchReportRequest::FILTER_PROPERTY_DOMAIN,
        SearchReportRequest::FILTER_OPERATOR_EQUAL,
        "www.bbc.co.uk"
    )
    ->execute();

$reports = $searchResponse->getReports();
echo "Found: " . count($reports) . " reports \n";

foreach ($reports as $report) {
    echo "ReportId: " . $report->getId() . "; Score: " . $report->getOverallScore() . "\n";
}