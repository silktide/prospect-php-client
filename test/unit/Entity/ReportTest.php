<?php

namespace Silktide\ProspectClient\UnitTest\Entity;

use PHPUnit\Framework\TestCase;
use Silktide\ProspectClient\Entity\Report;

class ReportTest extends TestCase
{
    public function testGetId()
    {
        $val = uniqid("reportId-");
        $sut = new Report(["report_id" => $val]);
        self::assertEquals($val, $sut->getId());
    }

    public function testGetAccountId()
    {
        $val = uniqid("accountId-");
        $sut = new Report(["account_id" => $val]);
        self::assertEquals($val, $sut->getAccountId());
    }

    public function testGetDomain()
    {
        $val = uniqid("domain-");
        $sut = new Report(["domain" => $val]);
        self::assertEquals($val, $sut->getDomain());
    }

    public function testGetOverallScore()
    {
        $val = rand(1, 99);
        $sut = new Report(["overall_score" => $val]);
        self::assertEquals($val, $sut->getOverallScore());
    }

    public function testGetReportSection()
    {
        $sectionName = uniqid("name-");
        $json = [
            $sectionName => [
                "example1" => 123,
                "example2" => 456,
            ],
        ];

        $sut = new Report($json);
        self::assertEquals($json[$sectionName], $sut->getReportSection($sectionName));
    }

    public function testGetMetaValue()
    {
        $metaKey = uniqid("key-");
        $metaValue = uniqid("value-");

        $json = [
            "meta" => [
                $metaKey => $metaValue,
            ]
        ];

        $sut = new Report($json);
        self::assertEquals($json["meta"][$metaKey], $sut->getMetaValue($metaKey));
    }

    public function testGetValue()
    {
        $key = uniqid("key-");
        $value = uniqid("value-");
        $json = [
            $key => $value
        ];

        $sut = new Report($json);
        self::assertEquals($value, $sut->getValue($key));
    }
}