<?php

namespace Silktide\ProspectClient\Data;

use ArrayObject;

class QueryStringData extends ArrayObject
{
    public function __toString(): string
    {
        return http_build_query($this);
    }
}