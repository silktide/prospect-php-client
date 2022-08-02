<?php

namespace Silktide\ProspectClient;

use Silktide\ProspectClient\Api\ReportApi;
use Silktide\ProspectClient\Http\HttpWrapper;

class ProspectClient
{
    private HttpWrapper $httpWrapper;

    private function __construct(HttpWrapper $httpWrapper)
    {
        $this->httpWrapper = $httpWrapper;
    }

    public static function createFromApiKey(string $apiKey, ?string $locale = null, ?string $host = null): ProspectClient
    {
        return new ProspectClient(new HttpWrapper($apiKey, $locale, null, $host));
    }

    public static function createFromHttpWrapper(HttpWrapper $httpWrapper): ProspectClient
    {
        return new ProspectClient($httpWrapper);
    }

    public function getReportApi(): ReportApi
    {
        return new ReportApi($this->httpWrapper);
    }
}
