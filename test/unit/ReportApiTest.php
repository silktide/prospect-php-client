<?php

namespace Silktide\ProspectClient\UnitTest;

use PHPUnit\Framework\TestCase;
use Silktide\ProspectClient\Api\AbstractApi;
use Silktide\ProspectClient\Api\ReportApi;
use Silktide\ProspectClient\ApiResponse\AbstractApiResponse;

class ReportApiTest extends TestCase
{
    public function testReportIsInstanceOfAbstractApi()
    {
        $sut = new ReportApi();
        self::assertInstanceOf(AbstractApi::class, $sut);
    }

    public function testFetch()
    {
        $reportId = 123;

        $sut = new ReportApi();
        $response = $sut->fetch($reportId);

        self::assertInstanceOf(AbstractApiResponse::class, $response);
    }
}