<?php

namespace Silktide\ProspectClient\UnitTest\Data;

use PHPUnit\Framework\TestCase;
use Silktide\ProspectClient\Data\BodyData;

class BodyDataTest extends TestCase
{
    public function testEmpty()
    {
        $sut = new BodyData();
        self::assertEquals("", $sut);
    }

    public function testSingleProperty()
    {
        $key = uniqid("key-");
        $value = uniqid("value-");
        $object = (object)[
            $key => $value,
        ];
        $expectedJson = json_encode($object);

        $sut = new BodyData();
        $sut->set($key, $value);

        self::assertEquals($expectedJson, $sut);
    }

    public function testManyProperty()
    {
        $sut = new BodyData();
        $kvpArray = [];

        for($i = 0; $i < 100; $i++) {
            $key = uniqid("key-");
            $value = uniqid("value-");
            $kvpArray[$key] = $value;

            $sut->set($key, $value);
        }

        $expectedJson = json_encode($kvpArray);
        self::assertEquals($expectedJson, $sut);
    }
}