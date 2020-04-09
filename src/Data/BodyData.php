<?php

namespace Silktide\ProspectClient\Data;

use Silktide\ProspectClient\Api\Fields\AbstractApiFields;

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

    public function setFields(AbstractApiFields $fields): void
    {
        foreach($fields as $key => $value) {
            $this->set($key, $value);
        }
    }
}