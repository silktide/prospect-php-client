<?php

namespace Silktide\ProspectClient\Data;

use ArrayObject;

abstract class AbstractData extends ArrayObject
{
    public function set(string $key, $value): void
    {
        $this->offsetSet($key, $value);
    }
}