<?php
require __DIR__ . "/vendor/autoload.php";

use Silktide\ProspectClient\ProspectClient;

$apiKey = getenv("PROSPECT_API_KEY");
$prospectClient = new ProspectClient($apiKey);

$reportApi = $prospectClient->getReportApi();

$response = $reportApi->create()
    ->setUrl("bbc.co.uk")
    ->setCheckForExisting(new DateTime("-10 days"))
    ->execute();

$reportId = $response->getReportId();
echo "Created report: " . $reportId . PHP_EOL;

do {
    $report = null;

    $fetchResponse = $reportApi->fetch()->setId($reportId)->execute();
    $report = $fetchResponse->getReport();
    $status = $report->getReportStatus();

    echo ".";
    sleep(5);
}
while($status !== "complete");

echo PHP_EOL;

echo "Overall score: " . $report->getOverallScore() . PHP_EOL;

$amountOfContentSection = $report->getReportSection("amount_of_content");
echo "Total word count: " . $amountOfContentSection["total_word_count"] . PHP_EOL;