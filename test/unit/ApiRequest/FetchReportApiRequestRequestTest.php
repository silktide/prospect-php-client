<?php

namespace Silktide\ProspectClient\UnitTest\ApiRequest;

use Silktide\ProspectClient\ApiException\ReportStillRunningException;
use Silktide\ProspectClient\ApiRequest\FetchReportApiRequest;
use Silktide\ProspectClient\ApiRequest\ReportIdNotSetException;

class FetchReportApiRequestRequestTest extends HttpRequestTestCase
{
    public function testSetId()
    {
        $id = uniqid("id-");
        $httpWrapper = self::getMockHttpWrapper(
            "report/$id",
            "GET"
        );
        $sut = new FetchReportApiRequest($httpWrapper);
        $sut->setId($id);
        $sut->execute();
    }

    public function testExecuteNoId()
    {
        $httpWrapper = self::getMockHttpWrapper();
        $sut = new FetchReportApiRequest($httpWrapper);
        self::expectException(ReportIdNotSetException::class);
        $sut->execute();
    }

    public function testExecute202()
    {
        $id = uniqid("id-");
        $httpWrapper = self::getMockHttpWrapper(
            "report/$id",
            "GET",
            null,
            null,
            [],
            202
        );
        $sut = new FetchReportApiRequest($httpWrapper);
        $sut->setId($id);
        self::expectException(ReportStillRunningException::class);
        $sut->execute();
    }
}