<?php

namespace Silktide\ProspectClient\Api;

use Silktide\ProspectClient\Http\HttpWrapper;

abstract class AbstractApi
{
    /** @var HttpWrapper */
    protected $httpWrapper;

    public function __construct(HttpWrapper $httpWrapper)
    {
        $this->httpWrapper = $httpWrapper;
    }
}