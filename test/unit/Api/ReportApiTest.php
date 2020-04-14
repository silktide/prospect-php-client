<?php

namespace Silktide\ProspectClient\UnitTest\Api;

use DateTime;
use PHPUnit\Framework\MockObject\MockObject;
use Silktide\ProspectClient\Api\AbstractApi;
use Silktide\ProspectClient\Api\Fields\ReportApiFields;
use Silktide\ProspectClient\Api\ReportApi;
use Silktide\ProspectClient\ApiException\ReportAlreadyExistsException;
use Silktide\ProspectClient\ApiResponse\CreatedReportApiResponse;
use Silktide\ProspectClient\ApiResponse\ExistingReportApiResponse;
use Silktide\ProspectClient\ApiResponse\ReportApiResponse;
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
        $reportId = 123;

        $httpClient = self::mockHttpClient(
            self::TEST_API_KEY,
            "GET",
            ReportApi::API_HOST,
            implode("/", [
                ReportApi::API_PATH_VERSION,
                ReportApi::API_PATH_PREFIX,
                $reportId
            ]
        ));

        $sut = new ReportApi(self::TEST_API_KEY, $httpClient);
        $response = $sut->fetch($reportId);
        self::assertInstanceOf(ReportApiResponse::class, $response);
    }

    public function testCreate()
    {
        $siteUrl = "https://example.silktide.com";
        $expectedId = uniqid();

        $httpClient = self::mockHttpClient(
            self::TEST_API_KEY,
            "POST",
            ReportApi::API_HOST,
            implode("/", [
                ReportApi::API_PATH_VERSION,
                ReportApi::API_PATH_PREFIX
            ]),
            null,
            [
                "status" => "running",
                "reportId" => $expectedId,
            ]
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
            implode("/", [
                ReportApi::API_PATH_VERSION,
                ReportApi::API_PATH_PREFIX
            ]),
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

    public function testReanalyze()
    {
        $reportId = uniqid();

        $httpClient = self::mockHttpClient(
            self::TEST_API_KEY,
            "POST",
          ReportApi::API_HOST,
            implode("/", [
                ReportApi::API_PATH_VERSION,
                ReportApi::API_PATH_PREFIX,
                $reportId
            ]),
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
            implode("/", [
                ReportApi::API_PATH_VERSION,
                ReportApi::API_PATH_PREFIX,
                $reportId
            ]),
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
        foreach($customKvp as $key => $value) {
            $requestBodyJsonFields["_" . $key] = $value;
        }

        $httpClient = self::mockHttpClient(
            self::TEST_API_KEY,
            "POST",
            ReportApi::API_HOST,
            implode("/", [
                ReportApi::API_PATH_VERSION,
                ReportApi::API_PATH_PREFIX,
                $reportId
            ]),
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
}