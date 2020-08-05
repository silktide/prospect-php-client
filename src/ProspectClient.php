<?php
namespace Silktide\ProspectClient;

use Silktide\ProspectClient\Api\ReportApi;
use Silktide\ProspectClient\Http\HttpWrapper;

class ProspectClient
{
    private HttpWrapper $httpWrapper;

    public function __construct(string $apiKey, HttpWrapper $httpWrapper = null)
    {
        $this->httpWrapper = $httpWrapper ?? new HttpWrapper($apiKey);
    }

    public function getReportApi():ReportApi
    {
        return new ReportApi($this->httpWrapper);
    }
}