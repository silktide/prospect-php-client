<?php

require __DIR__ . "/../vendor/autoload.php";

use Symfony\Component\Dotenv\Dotenv;
use Silktide\ProspectClient\ProspectClient;

$envFile = __DIR__ . "/../.env";
if (file_exists($envFile)) {
    (new Dotenv())->load($envFile);
}
$apiKey = $_ENV["PROSPECT_API_KEY"] ?? null;

if (!is_string($apiKey)) {
    throw new \Exception("An API key should be specified in the ./env file to run the examples");
}

$prospectClient = ProspectClient::createFromApiKey($apiKey);
$reportApi = $prospectClient->getReportApi();

$websiteName = "BBC";
$host = "bbc.co.uk";

$response = $reportApi->create()
    ->setUrl("https://www.$host")
    ->setCustomField("myCustomField", $host)
    ->setName("BBC")
    ->execute();

$reportId = $response->getReportId();
echo "Report ID: " . $reportId . PHP_EOL;

$reportStatus = "";
while ($reportStatus !== "complete") {
    sleep(5);
    $response = $reportApi->fetch($reportId)->execute();
    $report = $response->getReport();
    $requestStatus = $response->getRequestStatus();
    $reportStatus = $response->getReportStatus();
    echo "ReportStatus: " . $reportStatus . "\n";
}
echo "Report created!\n";
echo "Overall score: " . $report->getOverallScore() . PHP_EOL;

$amountOfContentSection = $report->getReportSection("amount_of_content");
echo "Total word count: " . $amountOfContentSection["total_word_count"] . PHP_EOL;
