<?php

namespace Silktide\ProspectClient\UnitTest\ApiRequest;

use Silktide\ProspectClient\ApiRequest\ReanalyzeReportApiRequest;
use Silktide\ProspectClient\ApiRequest\ReportIdNotSetException;

class ReanalyzeReportApiRequestRequestTest extends HttpRequestTestCase
{
    public function testSetId()
    {
        $id = uniqid("id-");
        $httpWrapper = self::getReanalyzeMockHttpWrapper($id);
        $sut = new ReanalyzeReportApiRequest($httpWrapper);
        $sut->setId($id);
        $sut->execute();
    }

    public function testSetCustomField()
    {
        $id = uniqid("id-");
        $key = uniqid("key-");
        $value = uniqid("value-");
        $httpWrapper = self::getReanalyzeMockHttpWrapper(
            $id,
            [
                "_$key" => $value,
            ]
        );
        $sut = new ReanalyzeReportApiRequest($httpWrapper);
        $sut->setId($id);
        $sut->setCustomField($key, $value);
        $sut->execute();
    }

    public function testSetCompletionWebhook()
    {
        $id = uniqid("id-");
        $webhook = uniqid("https://example.silktide.com/webhook-");
        $httpWrapper = self::getReanalyzeMockHttpWrapper(
            $id,
            [
                "on_completion" => $webhook,
            ]
        );
        $sut = new ReanalyzeReportApiRequest($httpWrapper);
        $sut->setId($id);
        $sut->setCompletionWebhook($webhook);
        $sut->execute();
    }

    public function testExecuteNoId()
    {
        $httpWrapper = self::getReanalyzeMockHttpWrapper(null);
        $sut = new ReanalyzeReportApiRequest($httpWrapper);
        self::expectException(ReportIdNotSetException::class);
        $sut->execute();
    }

    private function getReanalyzeMockHttpWrapper(?string $id, array $body = null)
    {
        $path = "/report/";
        if ($id) {
            $path .= $id;
        } else {
            $path = null;
        }

        return self::getMockHttpWrapper(
            $path,
            "POST",
            null,
            $body
        );
    }
}