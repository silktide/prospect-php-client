<?php

namespace Silktide\ProspectClient\UnitTest\ApiResponse;

use Silktide\ProspectClient\ApiException\ReportAlreadyExistsException;
use Silktide\ProspectClient\ApiException\ReportPathDoesNotExistException;
use Silktide\ProspectClient\ApiException\ReportPathUnprocessableException;
use Silktide\ProspectClient\Response\CreateReportResponse;

class CreateReportApiResponseTest extends HttpResponseTestCase
{
    public function testReportAlreadyExists()
    {
        $httpResponse = self::getMockHttpResponse(null, 303);
        self::expectException(ReportAlreadyExistsException::class);
        new CreateReportResponse($httpResponse);
    }

    public function testReportPathUnprocessable()
    {
        $httpResponse = self::getMockHttpResponse(null, 400);
        self::expectException(ReportPathUnprocessableException::class);
        new CreateReportResponse($httpResponse);
    }

    public function testReportPathDoesNotExist()
    {
        $httpResponse = self::getMockHttpResponse(null, 422);
        self::expectException(ReportPathDoesNotExistException::class);
        new CreateReportResponse($httpResponse);
    }
}