<?php

namespace Silktide\ProspectClient\UnitTest\Api;

use DateTime;
use PHPUnit\Framework\MockObject\MockObject;
use Silktide\ProspectClient\Api\AbstractApi;
use Silktide\ProspectClient\Api\Fields\ReportApiFields;
use Silktide\ProspectClient\Api\Filter\ReportApiFilter;
use Silktide\ProspectClient\Api\ReportApi;
use Silktide\ProspectClient\ApiException\ReportAlreadyExistsException;
use Silktide\ProspectClient\ApiException\ReportNotFoundException;
use Silktide\ProspectClient\ApiException\ReportPathDoesNotExistException;
use Silktide\ProspectClient\ApiException\ReportStillRunningException;
use Silktide\ProspectClient\ApiException\ReportPathUnprocessableException;
use Silktide\ProspectClient\ApiResponse\CreatedReportApiResponse;
use Silktide\ProspectClient\ApiResponse\ExistingReportApiResponse;
use Silktide\ProspectClient\ApiResponse\ListReportApiResponse;
use Silktide\ProspectClient\ApiResponse\ReportApiResponse;
use Silktide\ProspectClient\Data\QueryStringData;
use Silktide\ProspectClient\UnitTest\HttpTestCase;

class ReportApiTest extends HttpTestCase
{
    const TEST_API_KEY = "0123456789abcdef";

    public function testReportIsInstanceOfAbstractApi()
    {
        $sut = new ReportApi(self::TEST_API_KEY);
        self::assertInstanceOf(AbstractApi::class, $sut);
    }

    public function testFetch()
    {
        $reportId = uniqid();

        $httpClient = self::mockHttpClient(
            self::TEST_API_KEY,
            "GET",
            ReportApi::API_HOST,
            implode(
                "/",
                [
                    ReportApi::API_PATH_VERSION,
                    ReportApi::API_PATH_PREFIX_SINGLE_REPORT,
                    $reportId
                ]
            )
        );

        $sut = new ReportApi(self::TEST_API_KEY, $httpClient);
        $response = $sut->fetch($reportId);
        self::assertInstanceOf(ReportApiResponse::class, $response);
    }

    public function testFetchStillRunning()
    {
        $reportId = uniqid();
        $httpClient = self::mockHttpClient(
            self::TEST_API_KEY,
            "GET",
            ReportApi::API_HOST,
            implode(
                "/",
                [
                    ReportApi::API_PATH_VERSION,
                    ReportApi::API_PATH_PREFIX_SINGLE_REPORT,
                    $reportId
                ]
            ),
            null,
            null,
            202
        );

        $sut = new ReportApi(self::TEST_API_KEY, $httpClient);

        self::expectException(ReportStillRunningException::class);
        $sut->fetch($reportId);
    }

    public function testFetchNotFound()
    {
        $reportId = uniqid();
        $httpClient = self::mockHttpClient(
            self::TEST_API_KEY,
            "GET",
            ReportApi::API_HOST,
            implode(
                "/",
                [
                    ReportApi::API_PATH_VERSION,
                    ReportApi::API_PATH_PREFIX_SINGLE_REPORT,
                    $reportId
                ]
            ),
            null,
            null,
            404
        );

        $sut = new ReportApi(self::TEST_API_KEY, $httpClient);

        self::expectException(ReportNotFoundException::class);
        $sut->fetch($reportId);
    }

    public function testCreate()
    {
        $siteUrl = "https://example.silktide.com";
        $expectedId = uniqid();

        $httpClient = self::mockHttpClient(
            self::TEST_API_KEY,
            "POST",
            ReportApi::API_HOST,
            implode(
                "/",
                [
                    ReportApi::API_PATH_VERSION,
                    ReportApi::API_PATH_PREFIX_SINGLE_REPORT
                ]
            ),
            null,
            [
                "status" => "running",
                "reportId" => $expectedId,
            ],
            202
        );

        $sut = new ReportApi(self::TEST_API_KEY, $httpClient);
        $response = $sut->create($siteUrl);

        self::assertInstanceOf(CreatedReportApiResponse::class, $response);
        self::assertEquals($expectedId, $response->getReportId());
    }

    public function testCreateAlreadyExist()
    {
        $siteUrl = "https://example.silktide.com";
        $expectedId = uniqid();
        $checkBefore = new DateTime("-1 week");

        $requestBodyJsonFields = [
            "url" => $siteUrl,
            "check_for_existing" => $checkBefore->format(DateTime::ISO8601),
        ];

        $responseBodyJsonFields = [
            "status" => "running",
            "reportId" => $expectedId,
        ];

        $httpClient = self::mockHttpClient(
            self::TEST_API_KEY,
            "POST",
            ReportApi::API_HOST,
            implode(
                "/",
                [
                    ReportApi::API_PATH_VERSION,
                    ReportApi::API_PATH_PREFIX_SINGLE_REPORT
                ]
            ),
            $requestBodyJsonFields,
            $responseBodyJsonFields,
            303
        );

        /** @var MockObject|ReportApiFields $fields */
        $fields = self::createMockIterator(
            ReportApiFields::class,
            $requestBodyJsonFields
        );

        $sut = new ReportApi(self::TEST_API_KEY, $httpClient);
        self::expectException(ReportAlreadyExistsException::class);
        $sut->create($siteUrl, $fields);
    }

    public function testCreatePathUnprocessable()
    {
        $siteUrl = "ftp://why-ftp.silktide.com";

        $requestBodyJsonFields = [
            "url" => $siteUrl,
        ];

        $httpClient = self::mockHttpClient(
            self::TEST_API_KEY,
            "POST",
            ReportApi::API_HOST,
            implode(
                "/",
                [
                    ReportApi::API_PATH_VERSION,
                    ReportApi::API_PATH_PREFIX_SINGLE_REPORT
                ]
            ),
            $requestBodyJsonFields,
            null,
            400
        );

        /** @var MockObject|ReportApiFields $fields */
        $fields = self::createMockIterator(
            ReportApiFields::class,
            $requestBodyJsonFields
        );

        $sut = new ReportApi(self::TEST_API_KEY, $httpClient);
        self::expectException(ReportPathUnprocessableException::class);
        $sut->create($siteUrl, $fields);
    }

    public function testCreatePathDoesNotExist()
    {
        $siteUrl = "https://this.does.not.exist.silktide.com";

        $requestBodyJsonFields = [
            "url" => $siteUrl,
        ];

        $httpClient = self::mockHttpClient(
            self::TEST_API_KEY,
            "POST",
            ReportApi::API_HOST,
            implode(
                "/",
                [
                    ReportApi::API_PATH_VERSION,
                    ReportApi::API_PATH_PREFIX_SINGLE_REPORT
                ]
            ),
            $requestBodyJsonFields,
            null,
            422
        );

        /** @var MockObject|ReportApiFields $fields */
        $fields = self::createMockIterator(
            ReportApiFields::class,
            $requestBodyJsonFields
        );

        $sut = new ReportApi(self::TEST_API_KEY, $httpClient);
        self::expectException(ReportPathDoesNotExistException::class);
        $sut->create($siteUrl, $fields);
    }

    public function testReanalyze()
    {
        $reportId = uniqid();

        $httpClient = self::mockHttpClient(
            self::TEST_API_KEY,
            "POST",
            ReportApi::API_HOST,
            implode(
                "/",
                [
                    ReportApi::API_PATH_VERSION,
                    ReportApi::API_PATH_PREFIX_SINGLE_REPORT,
                    $reportId
                ]
            ),
            null,
            [
                "status" => "success",
                "reportId" => $reportId,
            ]
        );

        $sut = new ReportApi(self::TEST_API_KEY, $httpClient);
        $response = $sut->reanalyze($reportId);

        self::assertInstanceOf(ExistingReportApiResponse::class, $response);

        self::assertEquals(
            $reportId,
            $response->getReportId()
        );
    }

    public function testReanalyzeWithCallback()
    {
        $reportId = uniqid();
        $callbackUri = "https://example.silktide.com/" . uniqid("callback-");

        $requestBodyJsonFields = [
            "onCompletion" => $callbackUri,
        ];

        $httpClient = self::mockHttpClient(
            self::TEST_API_KEY,
            "POST",
            ReportApi::API_HOST,
            implode(
                "/",
                [
                    ReportApi::API_PATH_VERSION,
                    ReportApi::API_PATH_PREFIX_SINGLE_REPORT,
                    $reportId
                ]
            ),
            $requestBodyJsonFields,
            [
                "status" => "success",
                "reportId" => $reportId,
            ]
        );

        /** @var MockObject|ReportApiFields $fields */
        $fields = self::createMockIterator(
            ReportApiFields::class,
            $requestBodyJsonFields
        );

        $sut = new ReportApi(self::TEST_API_KEY, $httpClient);
        $response = $sut->reanalyze($reportId, $fields);

        self::assertInstanceOf(ExistingReportApiResponse::class, $response);

        self::assertEquals(
            $reportId,
            $response->getReportId()
        );
    }

    public function testReanalyzeWithCustomFields()
    {
        $reportId = uniqid();

        $customKvp = [
            uniqid("key-") => uniqid("value-"),
            uniqid("key-") => uniqid("value-"),
            uniqid("key-") => uniqid("value-"),
            uniqid("key-") => uniqid("value-"),
            uniqid("key-") => uniqid("value-"),
        ];

        $requestBodyJsonFields = [];
        foreach ($customKvp as $key => $value) {
            $requestBodyJsonFields["_" . $key] = $value;
        }

        $httpClient = self::mockHttpClient(
            self::TEST_API_KEY,
            "POST",
            ReportApi::API_HOST,
            implode(
                "/",
                [
                    ReportApi::API_PATH_VERSION,
                    ReportApi::API_PATH_PREFIX_SINGLE_REPORT,
                    $reportId
                ]
            ),
            $requestBodyJsonFields,
            [
                "status" => "success",
                "reportId" => $reportId,
            ]
        );

        /** @var MockObject|ReportApiFields $fields */
        $fields = self::createMockIterator(
            ReportApiFields::class,
            $requestBodyJsonFields
        );

        $sut = new ReportApi(self::TEST_API_KEY, $httpClient);
        $response = $sut->reanalyze($reportId, $fields);

        self::assertInstanceOf(ExistingReportApiResponse::class, $response);

        self::assertEquals(
            $reportId,
            $response->getReportId()
        );
    }

    public function testSearch()
    {
        $httpClient = self::mockHttpClient(
            self::TEST_API_KEY,
            "GET",
            ReportApi::API_HOST,
            implode(
                "/",
                [
                    ReportApi::API_PATH_VERSION,
                    ReportApi::API_PATH_PREFIX_LIST_REPORTS,
                ]
            )
        );

        $sut = new ReportApi(self::TEST_API_KEY, $httpClient);
        $response = $sut->search();

        self::assertInstanceOf(ListReportApiResponse::class, $response);
    }

    public function testSearchSingleFilter()
    {
        $json = json_encode(
            [
                (object)[
                    "operator" => "equal",
                    "property" => "mobile.is_mobile",
                    "targetValue" => false
                ],
            ]
        );
        $expectedQueryString = http_build_query(["filter" => $json]);

        $queryStringData = self::createMock(QueryStringData::class);
        $queryStringData->method("__toString")
            ->willReturn($expectedQueryString);

        $filter = self::createMock(ReportApiFilter::class);
        $filter->method("asQueryStringData")
            ->willReturn($queryStringData);

        $httpClient = self::mockHttpClient(
            self::TEST_API_KEY,
            "GET",
            ReportApi::API_HOST,
            implode(
                "/",
                [
                    ReportApi::API_PATH_VERSION,
                    ReportApi::API_PATH_PREFIX_LIST_REPORTS,
                ]
            )
        );

        $sut = new ReportApi(self::TEST_API_KEY, $httpClient);
        $response = $sut->search($filter);

        self::assertInstanceOf(ListReportApiResponse::class, $response);
    }

    public function testSearchFilterExtraAttributes()
    {
        $filterJson = json_encode(
            [
                (object)[
                    "operator" => "equal",
                    "property" => "mobile.is_mobile",
                    "targetValue" => false
                ],
            ]
        );
        $orderJson = json_encode(
            [
                (object)[
                    "runDate" => "desc",
                ]
            ]
        );

        $expectedQueryString = http_build_query([
            "filter" => $filterJson,
            "order" => $orderJson,
            "limit" => 50,
            "offset" => 150,

        ]);

        $queryStringData = self::createMock(QueryStringData::class);
        $queryStringData->method("__toString")
            ->willReturn($expectedQueryString);

        $filter = self::createMock(ReportApiFilter::class);
        $filter->method("asQueryStringData")
            ->willReturn($queryStringData);

        $httpClient = self::mockHttpClient(
            self::TEST_API_KEY,
            "GET",
            ReportApi::API_HOST,
            implode(
                "/",
                [
                    ReportApi::API_PATH_VERSION,
                    ReportApi::API_PATH_PREFIX_LIST_REPORTS,
                ]
            )
        );

        $sut = new ReportApi(self::TEST_API_KEY, $httpClient);
        $response = $sut->search($filter);

        self::assertInstanceOf(ListReportApiResponse::class, $response);
    }
}