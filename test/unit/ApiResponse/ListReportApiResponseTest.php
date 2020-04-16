<?php

namespace Silktide\ProspectClient\UnitTest\ApiResponse;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Silktide\ProspectClient\ApiResponse\FetchedReportApiResponse;
use Silktide\ProspectClient\ApiResponse\ListReportApiResponse;
use Silktide\ProspectClient\Entity\Report;

class ListReportApiResponseTest extends TestCase
{
    public function testGetReport()
    {
        $dummyReportArray = [
            "first",
            "second",
            "third",
        ];

        $bodyFields = (object)[
            "reports" => $dummyReportArray
        ];

        $httpResponse = self::createMock(ResponseInterface::class);
        $httpResponse->method("getStatusCode")
            ->willReturn(200);
        $httpResponse->method("getBody")
            ->willReturn(json_encode($bodyFields));

        $sut = new ListReportApiResponse($httpResponse);

        for($i = 0, $length = count($dummyReportArray); $i < $length; $i++) {
            self::assertInstanceOf(Report::class, $sut->getReport($i));
        }

// Now $i is one higher than the dummyReportArray length.
        self::assertNull($sut->getReport($i));
    }

    public function testGetReports()
    {
        $dummyReportArray = [
            "first",
            "second",
            "third",
        ];

        $bodyFields = (object)[
            "reports" => $dummyReportArray
        ];

        $httpResponse = self::createMock(ResponseInterface::class);
        $httpResponse->method("getStatusCode")
            ->willReturn(200);
        $httpResponse->method("getBody")
            ->willReturn(json_encode($bodyFields));

        $sut = new ListReportApiResponse($httpResponse);
        $reports = $sut->getAllReports();
        self::assertIsArray($reports);
        self::assertCount(count($dummyReportArray), $reports);
        self::assertInstanceOf(Report::class, $reports[0]);
    }
}