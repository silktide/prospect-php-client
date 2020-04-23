<?php

include("vendor/autoload.php");


$apiKey = "fred";

$prospectClient = \Silktide\ProspectClient\ProspectClient::create($apiKey);

$reportApi = $prospectClient->getReportApi();

$response = $reportApi
    ->create()
    ->setUrl("https://example.silktide.com")
    ->setCompletionWebhook("https://example.silktide.com/report_complete.php")
    ->setAddress("Silktide LTD", "", "Brunel Parkway, Pride Park", "Derby", "Derbyshire", "DE24 8HR", "GB")
    ->execute();