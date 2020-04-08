<?php
namespace Silktide\ProspectClient\UnitTest\Data;

use PHPUnit\Framework\TestCase;
use Silktide\ProspectClient\Data\QueryStringData;

class QueryStringDataTest extends TestCase
{
    public function testEmpty()
    {
        $sut = new QueryStringData();
        self::assertEquals("", $sut);
    }

    public function testSingleParameter()
    {
        $key = uniqid("key-");
        $value = uniqid("value-");

        $sut = new QueryStringData();
        $sut[$key] = $value;

        self::assertEquals("$key=$value", $sut);
    }

    public function testMultipleParameters() {
        $sut = new QueryStringData();
        $expectedQueryString = "";

        $kvpArray = [];
        for($i = 0; $i < 100; $i++) {
            $key = uniqid("key-");
            $value = uniqid("value-");
            $kvpArray[$key] = $value;
            $sut[$key] = $value;

            if(strlen($expectedQueryString) > 0) {
                $expectedQueryString .= "&";
            }
            $expectedQueryString .= "$key=$value";
        }

        self::assertEquals($expectedQueryString, $sut);
    }

    public function testEncoding()
    {
        $testString = "Price is £12.34 with 20% added & no discount!";
        $testStringEncoded = urlencode($testString);

        $sut = new QueryStringData();
        $sut["test-key"] = $testString;

        self::assertEquals("test-key=$testStringEncoded", $sut);
    }
}