<?php

namespace Silktide\ProspectClient\UnitTest\ApiResponse;

use Silktide\ProspectClient\ApiException\ReportNotFoundException;
use Silktide\ProspectClient\Response\FetchReportResponse;
use Silktide\ProspectClient\Entity\Report;

class FetchReportApiResponseTest extends HttpResponseTestCase
{
    public function testGetReport()
    {
        $httpResponse = self::getMockHttpResponse(
            [
                "status" => "testing",
                "report_status" => "report-testing",
                "report" => ["testKey" => "testValue"],
            ]
        );
        $sut = new FetchReportResponse($httpResponse);
        self::assertInstanceOf(Report::class, $sut->getReport());
    }

    public function testReportNotFound()
    {
        $httpResponse = self::getMockHttpResponse(null, 404);
        self::expectException(ReportNotFoundException::class);
        new FetchReportResponse($httpResponse);
    }

    public function testGetReportId()
    {
        $id = uniqid("id-");
        $httpResponse = self::getMockHttpResponse(
            [
                "reportId" => $id,
            ]
        );
        $sut = new FetchReportResponse($httpResponse);
        self::assertEquals($id, $sut->getReportId());
    }
}