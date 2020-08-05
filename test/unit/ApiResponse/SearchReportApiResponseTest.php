<?php

namespace Silktide\ProspectClient\UnitTest\ApiResponse;

use Silktide\ProspectClient\Response\SearchReportResponse;
use Silktide\ProspectClient\Entity\Report;

class SearchReportApiResponseTest extends HttpResponseTestCase
{
    public function testGetByIndexOutOfBounds()
    {
        $httpResponse = self::getMockHttpResponse(
            [
                "reports" => [
                    ["testKey" => "testValue"],
                ]
            ]
        );
        $sut = new SearchReportResponse($httpResponse);
        self::assertNull($sut->getByIndex(999));
    }

    public function testGetByIndex()
    {
        $report1 = ["testKey1" => "testValue1"];
        $report2 = ["testKey2" => "testValue2"];

        $httpResponse = self::getMockHttpResponse(
            [
                "reports" => [
                    $report1,
                    $report2,
                ]
            ]
        );
        $sut = new SearchReportResponse($httpResponse);
        $report1 = $sut->getByIndex(0);
        $report2 = $sut->getByIndex(1);

        self::assertEquals("testValue1", $report1->getValue("testKey1"));
        self::assertEquals("testValue2", $report2->getValue("testKey2"));
    }

    public function testIterator()
    {
        $id1 = uniqid();
        $id2 = uniqid();
        $id3 = uniqid();
        $ids = [$id1, $id2, $id3];

        $report1 = ["testKey1" => "testValue1", "report_id" => $id1];
        $report2 = ["testKey2" => "testValue2", "report_id" => $id2];
        $report3 = ["testKey3" => "testValue3", "report_id" => $id3];

        $httpResponse = self::getMockHttpResponse(
            [
                "reports" => [
                    $report1,
                    $report2,
                    $report3,
                ]
            ]
        );
        $sut = new SearchReportResponse($httpResponse);

        $i = 0;
        foreach ($sut as $id => $report) {
            self::assertInstanceOf(Report::class, $report);
            self::assertEquals($ids[$i], $id);
            $i++;
        }

        self::assertEquals(3, $i);
    }

    public function testCount()
    {
        $id1 = uniqid();
        $id2 = uniqid();
        $id3 = uniqid();

        $report1 = ["testKey1" => "testValue1", "report_id" => $id1];
        $report2 = ["testKey2" => "testValue2", "report_id" => $id2];
        $report3 = ["testKey3" => "testValue3", "report_id" => $id3];

        $httpResponse = self::getMockHttpResponse(
            [
                "reports" => [
                    $report1,
                    $report2,
                    $report3,
                ]
            ]
        );
        $sut = new SearchReportResponse($httpResponse);
        self::assertCount(3, $sut);
    }
}