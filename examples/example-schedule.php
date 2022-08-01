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

$reportId = "e56f86d16694f34339e7fb36a59e360560cc4c6c";

$prospectClient = ProspectClient::createFromApiKey($apiKey);
$scheduledReportApi = $prospectClient->getScheduledReportApi();

$response = $scheduledReportApi->schedule()
    ->setRunDate(new DateTime())
    ->setRepeatRuns(true)
    ->setFrequency(1)
    ->setFrequencyUnit('days')
    ->setStopAutomatically(false)
    ->setNotifyContacts(true)
    ->setNotificationEmails([
        'alexblackham@silktide.com'
    ])
    ->setNotificationMedium('link')
    ->execute();

echo "Schedule status: " . $response->getStatus() . PHP_EOL;
echo "Schedule data: " . PHP_EOL;
var_dump($response->getSchedule());
