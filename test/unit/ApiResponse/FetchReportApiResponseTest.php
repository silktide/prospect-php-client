<?php

namespace Silktide\ProspectClient\UnitTest\ApiResponse;

use Silktide\ProspectClient\ApiException\ReportNotFoundException;
use Silktide\ProspectClient\ApiResponse\FetchReportApiResponse;
use Silktide\ProspectClient\Entity\Report;

class FetchReportApiResponseTest extends HttpResponseTestCase
{
    public function testGetReport()
    {
        $httpResponse = self::getMockHttpResponse(
            [
                "report" => ["testKey" => "testValue"],
            ]
        );
        $sut = new FetchReportApiResponse($httpResponse);
        self::assertInstanceOf(Report::class, $sut->getReport());
    }

    public function testReportNotFound()
    {
        $httpResponse = self::getMockHttpResponse(null, 404);
        self::expectException(ReportNotFoundException::class);
        new FetchReportApiResponse($httpResponse);
    }

    public function testGetReportId()
    {
        $id = uniqid("id-");
        $httpResponse = self::getMockHttpResponse(
            [
                "reportId" => $id,
            ]
        );
        $sut = new FetchReportApiResponse($httpResponse);
        self::assertEquals($id, $sut->getReportId());
    }
}