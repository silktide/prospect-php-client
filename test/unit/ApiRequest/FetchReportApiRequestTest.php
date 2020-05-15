<?php

namespace Silktide\ProspectClient\UnitTest\ApiRequest;

use Silktide\ProspectClient\ApiException\ReportStillRunningException;
use Silktide\ProspectClient\ApiRequest\FetchReportApiRequest;
use Silktide\ProspectClient\ApiRequest\ReportIdNotSetException;

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
}