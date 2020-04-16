<?php

namespace Silktide\ProspectClient\UnitTest\Entity;

use PHPUnit\Framework\TestCase;
use Silktide\ProspectClient\Entity\Report;

class ReportTest extends TestCase
{
    public function testGetId()
    {
        $expectedId = uniqid();
        $mockBodyFields = (object)[
            "report_id" => $expectedId,
        ];

        $sut = new Report($mockBodyFields);
        self::assertEquals($expectedId, $sut->getId());
    }

    public function testGetAccountId()
    {
        $expectedAccountId = uniqid("account-");
        $mockBodyFields = (object)[
            "account_id" => $expectedAccountId,
        ];

        $sut = new Report($mockBodyFields);
        self::assertEquals($expectedAccountId, $sut->getAccountId());
    }

    public function testGetDomain()
    {
        $expectedDomain = uniqid("www.");
        $mockBodyFields = (object)[
            "domain" => $expectedDomain,
        ];

        $sut = new Report($mockBodyFields);
        self::assertEquals($expectedDomain, $sut->getDomain());
    }

    public function testGetOverallScore()
    {
        $expectedScore = random_int(0, 100);
        $mockBodyFields = (object)[
            "overall_score" => $expectedScore,
        ];

        $sut = new Report($mockBodyFields);
        self::assertEquals($expectedScore, $sut->getOverallScore());
    }

    public function testGetReportSection()
    {
        $sectionContactDetails = (object)[
            "email" => false,
            "telephone" => "01234 567890",
        ];
        $sectionLocalPresence = (object)[
            "detected_phone" => "+44 1322 460460",
            "detected_address" => "Silktide LTD, Brunel Parkway, Pride Park, DE24 8HR, United Kingdom, United Kingdom",
            "detected_name" => "Silktide",
        ];
        $mockBodyFields = (object)[
            "contact_details" => $sectionContactDetails,
            "local_presence" => $sectionLocalPresence,
        ];

        $sut = new Report($mockBodyFields);
        self::assertEquals($sectionContactDetails, $sut->getReportSection("contact_details"));
        self::assertEquals($sectionLocalPresence, $sut->getReportSection("local_presence"));
    }
}