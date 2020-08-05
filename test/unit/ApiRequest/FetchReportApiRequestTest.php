<?php

namespace Silktide\ProspectClient\UnitTest\ApiRequest;

use Silktide\ProspectClient\ApiException\ReportStillRunningException;
use Silktide\ProspectClient\Request\FetchReportRequest;
use Silktide\ProspectClient\Request\ReportIdNotSetException;

class FetchReportApiRequestTest extends HttpRequestTestCase
{
    public function testSetId()
    {
        $id = uniqid("id-");
        $httpWrapper = self::getMockHttpWrapper(
            "report/$id",
            "GET",
            ["categories" => "true"]
        );
        $sut = new FetchReportRequest($httpWrapper);
        $sut->setId($id);
        $sut->execute();
    }

    public function testExecuteNoId()
    {
        $httpWrapper = self::getMockHttpWrapper();
        $sut = new FetchReportRequest($httpWrapper);
        self::expectException(ReportIdNotSetException::class);
        $sut->execute();
    }
}