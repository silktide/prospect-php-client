<?php
require __DIR__ . "/vendor/autoload.php";

use Silktide\ProspectClient\ApiException\ReportStillRunningException;
use Silktide\ProspectClient\ProspectClient;
use Silktide\ProspectClient\ApiRequest\SearchReportApiRequest;

$apiKey = getenv("PROSPECT_API_KEY");
$prospectClient = new ProspectClient($apiKey);

$reportApi = $prospectClient->getReportApi();

$allReports = $reportApi->search()->setOrder(
    SearchReportApiRequest::ORDER_PROPERTY_RUN_DATE,
    SearchReportApiRequest::ORDER_DIRECTION_DESCENDING
)->execute();

echo "There are " . count($allReports) . " reports already made on the account with the following IDs:" . PHP_EOL;

foreach($allReports as $reportId => $report) {
    echo $reportId . "(" . $report->getDomain() . ")" . PHP_EOL;
}

sleep(1);
echo "Fetching the first report..." . PHP_EOL;
$report = $reportApi->fetch($reportId);

echo "This report was requested by " . $report->getMetaValue("requested_by") . PHP_EOL;
echo "Its overall score is " . $report->getOverallScore() . PHP_EOL;

echo "Creating a new report for example.silktide.com ..." . PHP_EOL;

$response = $reportApi->create()
    ->setUrl("https://example.silktide.com")
    ->setCompletionWebhook("https://example.silktide.com/report_complete.php")
    ->setAddress("Silktide LTD", "", "Brunel Parkway, Pride Park", "Derby", "Derbyshire", "DE24 8HR", "GB")
    ->execute();

$reportId = $response->getReportId();
echo "Created report: " . $reportId . PHP_EOL;

do {
    $report = null;

    try {
        $report = $reportApi->fetch($reportId);
    }
    catch(ReportStillRunningException $exception) {
        echo "Still running...";
        sleep(5);
    }
}
while(is_null($report));

echo "Overall score: " . $report->getOverallScore() . PHP_EOL;

$amountOfContentSection = $report->getReportSection("amount_of_content");
echo "Total word count: " . $amountOfContentSection["total_word_count"] . PHP_EOL;