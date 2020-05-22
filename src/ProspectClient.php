<?php
namespace Silktide\ProspectClient;

use Silktide\ProspectClient\Api\ReportApi;
use Silktide\ProspectClient\Http\HttpWrapper;

class ProspectClient
{
    /** @var HttpWrapper */
    private $httpWrapper;
    /** @var ReportApi */
    private $reportApi;

    public function __construct(string $apiKey, HttpWrapper $httpWrapper = null)
    {
        $this->httpWrapper = $httpWrapper ?? new HttpWrapper($apiKey);
    }

    public function getReportApi():ReportApi
    {
        if(!isset($this->reportApi)) {
            $this->reportApi = new ReportApi($this->httpWrapper);
        }

        return $this->reportApi;
    }
}