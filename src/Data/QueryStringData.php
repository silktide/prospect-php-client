<?php

namespace Silktide\ProspectClient\Data;

class QueryStringData extends AbstractData
{
    public function __toString(): string
    {
        return http_build_query($this->getArrayCopy());
    }
}