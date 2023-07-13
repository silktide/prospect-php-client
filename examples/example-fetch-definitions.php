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

$response = $reportApi->fetchDefinitions()->execute();

$definitions = $response->getDefinitions();

foreach ($definitions as $definition) {
    echo "Definition ID: " . $definition->getId() . PHP_EOL;
    var_dump($definition->getRawData());
    echo PHP_EOL;
}
