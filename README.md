# Deprecated

This has been moved to the Insites organisation and can now be found [here](https://github.com/insites/php-api-client)

~Prospect PHP Client~
=======================================================

Example usage
-------------

### Making Client

```php
// The actual API key needs to be created at https://app.prospect.silktide.com/en_GB/admin/settings#/api
$apiKey = "0123456789abcdef";
$prospectClient = \Silktide\ProspectClient\ProspectClient::createFromApiKey($apiKey);
$reportApi = $prospectClient->getReportApi();
```

For more in detail examples, see the `examples` folder

### Create a new report,
```php
$response = $reportApi->create()
    ->setUrl("https://example.silktide.com")
    ->setAddress("Silktide LTD", "17", "Brunel Parkway", "Pride Park", "Derby", "DE24 8HR")
    ->setName("Silktide")
    ->setPhone("01322 460460")
    ->execute();

echo "ReportId: " . $response->getReportId() . "\n";
```
  
