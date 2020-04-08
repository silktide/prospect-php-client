<?php

namespace Silktide\ProspectClient\UnitTest;

use PHPUnit\Framework\TestCase;
use Silktide\ProspectClient\DummyClass;

class DummyClassTest extends TestCase
{
    public function testDoesAThing() {
        $sut = new DummyClass();
        self::assertTrue($sut->isAThing());
    }
}