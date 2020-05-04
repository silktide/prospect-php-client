<?php

namespace Silktide\ProspectClient\Api;

use Silktide\ProspectClient\Http\HttpWrapper;

abstract class AbstractApi
{
    protected HttpWrapper $httpWrapper;

    public function __construct(HttpWrapper $httpWrapper)
    {
        $this->httpWrapper = $httpWrapper;
    }
}