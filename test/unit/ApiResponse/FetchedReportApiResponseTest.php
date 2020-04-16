<?php

namespace Silktide\ProspectClient\UnitTest\ApiResponse;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Silktide\ProspectClient\ApiResponse\FetchedReportApiResponse;
use Silktide\ProspectClient\Entity\Report;

class FetchedReportApiResponseTest extends TestCase
{
    public function testGetReport()
    {
        $httpResponse = self::createMock(ResponseInterface::class);
        $httpResponse->method("getStatusCode")
            ->willReturn(200);
        $httpResponse->method("getBody")
            ->willReturn(json_encode((object)[
                "report" => "nothing",
            ]));

        $sut = new FetchedReportApiResponse($httpResponse);
        self::assertInstanceOf(Report::class, $sut->getReport());
    }
}