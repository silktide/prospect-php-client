<?php

namespace Silktide\ProspectClient\Api\Filter;

use Silktide\ProspectClient\Data\QueryStringData;

class ReportApiFilter
{
    private array $parameters;

    public function __construct()
    {
        $this->parameters = [];
    }

    public function asQueryStringData():QueryStringData
    {
        return new QueryStringData($this->parameters);
    }
}