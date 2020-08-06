PHP client for integrating Prospect into your projects.
=======================================================

Example usage
-------------

### Create a new report, poll for it to be completed, then display the report

```php
use Silktide\ProspectClient\Api\ReportApi;
use Silktide\ProspectClient\Exception\Api\ReportStillRunningException;

// Keys can be loaded from the environment or passed to your script. 
// The actual API key needs to be created at https://app.prospect.silktide.com/en_GB/admin/settings#/api
define("PROSPECT_API_KEY", "0123456789abcdef");

$reportApi = new ReportApi(PROSPECT_API_KEY);
$reportId = $reportApi->create()
    ->setUrl("https://example.silktide.com")
    ->setAddress("Silktide LTD", "17", "Brunel Parkway", "Pride Park", "Derby", "DE24 8HR")
    ->setName("Silktide")
    ->setPhone("01322 460460")
    ->execute();
echo "Started report, waiting.";

do {
    try {
        $report = $reportApi->fetch($reportId);
        echo PHP_EOL;
        echo "Reporting complete!" . PHP_EOL . PHP_EOL;
    }
    catch(ReportStillRunningException $exception) {
        echo ".";
        sleep(1);
    }
}
while(is_null($report));

echo "Overall score:" . $report->getOverallScore() . PHP_EOL;

foreach($report as $reportName => $reportDetail) {
    echo "Report name: $reportName" . PHP_EOL;
    echo (string)$reportDetail;
    echo PHP_EOL . PHP_EOL;    
}
```

#### Example output:

```
Started report, waiting......
Reporting complete!

Report name: local_presence
detected_phone: +44 1322 460460
detected_address: Silktide LTD, Brunel Parkway, Pride Park, DE24 8HR, United Kingdom, United Kingdom
detected_name: Silktide

Report name: facebook_page
page_link: https://www.facebook.com/silktide
page_likes: 46560

Report name: organic_search
page_link: average_monthly_traffic

[ ... ]
```

### Passing API fields when creating the report

```php
$fields = new ReportApiFields();
$fields->completionWebhook("https://example.silktide.com/report_complete.php");
$fields->address("Silktide LTD", "", "Brunel Parkway, Pride Park", "Derby", "Derbyshire", "DE24 8HR", "GB");

$reportId = $reportApi->create("https://example.silktide.com", $fields);
```

Report
------

Function names may change after initial implementation but will need confirming before stable release.

+ `fetch(int $reportId):ReportApiResponse` - Fetch an existing business report.
+ `create(string $url, ?DateTime $checkForExisting, ?string $callbackUrl = null)` - Create a new report for given URL. Do not run again if existing report exists after optionally provided DateTime. Optionally provide Callback URL to POST JSON report data to.  