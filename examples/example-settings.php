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

$reportId = "e69ef2c48be24356a27ff77f5d6bf5ce1678e239";

$settingsResponse = $reportApi->settings($reportId)
    ->persistSetting('name', 'Business Co')
    ->persistSetting('phone', '012 345 6789')
    ->execute();

$settings = $settingsResponse->getSettings();
echo "Found: " . count($settings) . " settings \n";

foreach ($settings as $setting) {
    echo "ID: " . $setting->getId() . "; Value: " . $setting->getValue() . "\n";
}