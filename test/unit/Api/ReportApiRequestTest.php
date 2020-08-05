<?php

namespace Silktide\ProspectClient\UnitTest\Api;

use Silktide\ProspectClient\Api\ReportApi;
use Silktide\ProspectClient\Request\CreateReportRequest;
use Silktide\ProspectClient\Request\FetchReportRequest;
use Silktide\ProspectClient\Request\ReanalyzeReportRequest;
use Silktide\ProspectClient\Request\SearchReportRequest;
use Silktide\ProspectClient\Entity\Report;
use Silktide\ProspectClient\Http\HttpWrapper;
use Silktide\ProspectClient\UnitTest\ApiRequest\HttpRequestTestCase;

class ReportApiRequestTest extends HttpRequestTestCase
{
    public function testFetch()
    {
        $testId = uniqid("id-");

        $httpWrapper = self::createMock(HttpWrapper::class);

        $sut = new ReportApi($httpWrapper);
        self::assertInstanceOf(FetchReportRequest::class, $sut->fetch());
    }

    public function testCreate()
    {
        $sut = new ReportApi(self::createMock(HttpWrapper::class));
        self::assertInstanceOf(CreateReportRequest::class, $sut->create());
    }

    public function testReanalyze()
    {
        $sut = new ReportApi(self::createMock(HttpWrapper::class));
        self::assertInstanceOf(ReanalyzeReportRequest::class, $sut->reanalyze());
    }

    public function testSearch()
    {
        $sut = new ReportApi(self::createMock(HttpWrapper::class));
        self::assertInstanceOf(SearchReportRequest::class, $sut->search());
    }
}