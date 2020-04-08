<?php

namespace Silktide\ProspectClient\Data;

use function \GuzzleHttp\json_encode;

class BodyData extends AbstractData
{
    public function __toString(): string
    {
        if($this->count() === 0) {
            return "";
        }

        return json_encode($this);
    }
}