<?php


namespace Silktide\ProspectClient;


use GuzzleHttp\Client;
use Silktide\ProspectClient\Api\ReportApi;
use Silktide\ProspectClient\HTTP\HttpWrapper;

class ProspectClient
{
    protected $httpWrapper;

    public static function create(string $apiKey)
    {
        $httpClient = new Client();
        $httpWrapper = new HttpWrapper($httpClient, $apiKey);
        return new ProspectClient($httpWrapper);
    }

    protected function __construct(HttpWrapper $httpWrapper)
    {
        $this->httpWrapper = $httpWrapper;
    }

    public function getReportApi() : ReportApi
    {
        return new ReportApi($this->httpWrapper);
    }
}