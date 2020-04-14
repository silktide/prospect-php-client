<?php

namespace Silktide\ProspectClient\UnitTest\Api\Fields;

use DateTime;
use PHPUnit\Framework\TestCase;
use Silktide\ProspectClient\Api\Fields\ReportApiFields;

class ReportApiFieldsTest extends TestCase
{
    public function testIteratorEmpty()
    {
        $sut = new ReportApiFields();
        $key = null;

        /** @noinspection PhpStatementHasEmptyBodyInspection */
        foreach($sut as $key => $value) {}

        self::assertNull($key);
    }

    public function testIteratorCustomFieldSingle()
    {
        $expectedKey = uniqid("key-");
        $expectedValue = uniqid("value-");

        $sut = new ReportApiFields();
        $sut->customField($expectedKey, $expectedValue);

        foreach($sut as $key => $value) {
            self::assertEquals("_" . $expectedKey, $key);
            self::assertEquals($expectedValue, $value);
        }

        self::assertNotNull($key);
    }

    public function testIteratorCustomFieldMany()
    {
        $expectedKvp = [
            "first" => "This is the first",
            "second" => "This is the second",
            "third" => "This is the third",
        ];

        $sut = new ReportApiFields();
        foreach($expectedKvp as $key => $value) {
            $sut->customField($key, $value);
        }

        $i = 0;
        $expectedKeys = array_keys($expectedKvp);
        foreach($sut as $key => $value) {
            $expectedKey = $expectedKeys[$i];
            $expectedValue = $expectedKvp[$expectedKey];

            self::assertEquals("_" . $expectedKey, $key);
            self::assertEquals($expectedValue, $value);
            $i++;
        }

        self::assertEquals(count($expectedKvp), $i);
    }

    public function testCheckForExisting()
    {
        $expectedDateString = implode("-", [
            rand(1970, 2050),
            rand(01, 12),
            rand(01, 31),
        ]);
        $expectedDateString .= "T";
        $expectedDateString .= implode(":", [
            rand(0, 23),
            rand(0, 59),
            rand(0, 59),
        ]);
        $expectedDateString .= "+0" . rand(0, 9) . "00";

        $dateTime = self::createMock(DateTime::class);
        $dateTime->expects(self::once())
            ->method("format")
            ->with(DateTime::ISO8601)
            ->willReturn($expectedDateString);

        $sut = new ReportApiFields();
        $sut->checkForExisting($dateTime);

        self::assertEquals("check_for_existing", $sut->key());
        self::assertEquals($expectedDateString, $sut->current());
    }

    public function testCompletionWebhook()
    {
        $uri = "https://" . uniqid();

        $sut = new ReportApiFields();
        $sut->completionWebhook($uri);

        self::assertEquals("on_completion", $sut->key());
        self::assertEquals($uri, $sut->current());
    }

    public function testName()
    {
        $name = uniqid("name-");
        $sut = new ReportApiFields();
        $sut->name($name);
        self::assertEquals("name", $sut->key());
        self::assertEquals($name, $sut->current());
    }

    public function testPhone()
    {
        $phone = uniqid("phone-");
        $sut = new ReportApiFields();
        $sut->phone($phone);
        self::assertEquals("phone", $sut->key());
        self::assertEquals($phone, $sut->current());
    }

    public function testAddress()
    {
        $expectedAddress = [
            "address" => uniqid("first-line-"),
            "number" => rand(1, 500),
            "street" => uniqid("street-name-"),
            "city" => uniqid("city-name-"),
            "state" => uniqid("state-name-"),
            "zip" => uniqid("zip-"),
            "country_code" => uniqid("country-"),
        ];

        $sut = new ReportApiFields();
        $sut->address(...array_values($expectedAddress));

        $i = 0;
        $expectedAddressKeys = array_keys($expectedAddress);
        foreach($sut as $key => $value) {
            $expectedKey = $expectedAddressKeys[$i];
            $expectedValue = $expectedAddress[$expectedKey];

            self::assertEquals($expectedKey, $key);
            self::assertEquals($expectedValue, $value);
            $i++;
        }

        self::assertEquals(count($expectedAddress), $i);
    }
}