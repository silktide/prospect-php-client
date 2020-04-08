<?php

namespace Silktide\ProspectClient;

class DummyClass
{
    public function isAThing(): bool
    {
        return true;
    }

    public static function create(): DummyClass
    {
        return new DummyClass();
    }
}