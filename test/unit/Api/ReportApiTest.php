<?php

namespace Silktide\ProspectClient\UnitTest\Api;

use Silktide\ProspectClient\Api\AbstractApi;
use Silktide\ProspectClient\Api\ReportApi;
use Silktide\ProspectClient\ApiResponse\ReportApiResponse;
use Silktide\ProspectClient\UnitTest\HttpTestCase;

class ReportApiTest extends HttpTestCase
{
    const TEST_API_KEY = "0123456789abcdef";

    public function testReportIsInstanceOfAbstractApi()
    {
        $sut = new ReportApi(self::TEST_API_KEY);
        self::assertInstanceOf(AbstractApi::class, $sut);
    }

    public function testFetch()
    {
        $reportId = 123;

        $httpClient = self::mockHttpClient(
            self::TEST_API_KEY,
            "GET",
            ReportApi::API_HOST,
            implode("/", [
                ReportApi::API_PATH_VERSION,
                ReportApi::API_PATH_PREFIX,
                $reportId
            ]
        ));

        $sut = new ReportApi(self::TEST_API_KEY, $httpClient);
        $response = $sut->fetch($reportId);
        self::assertInstanceOf(ReportApiResponse::class, $response);
    }

    public function testCreate()
    {
        $siteUrl = "https://example.silktide.com";

        $httpClient = self::mockHttpClient(
            self::TEST_API_KEY,
            "POST",
            ReportApi::API_HOST,
            implode("/", [
                ReportApi::API_PATH_VERSION,
                ReportApi::API_PATH_PREFIX
            ])
        );

        $sut = new ReportApi(self::TEST_API_KEY, $httpClient);
        $reportId = $sut->create($siteUrl);
        self::assertIsString($reportId);
    }
}