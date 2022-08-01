<?php

namespace Silktide\ProspectClient;

use Silktide\ProspectClient\Api\ReportApi;
use Silktide\ProspectClient\Api\ScheduledReportApi;
use Silktide\ProspectClient\Http\HttpWrapper;

class ProspectClient
{
    private HttpWrapper $httpWrapper;

    private function __construct(HttpWrapper $httpWrapper)
    {
        $this->httpWrapper = $httpWrapper;
    }

    public static function createFromApiKey(string $apiKey, ?string $locale = null)
    {
        return new ProspectClient(new HttpWrapper($apiKey, $locale));
    }

    public static function createFromHttpWrapper(HttpWrapper $httpWrapper)
    {
        return new ProspectClient($httpWrapper);
    }

    public function getReportApi(): ReportApi
    {
        return new ReportApi($this->httpWrapper);
    }

    public function getScheduledReportApi(): ScheduledReportApi
    {
        return new ScheduledReportApi($this->httpWrapper);
    }
}
