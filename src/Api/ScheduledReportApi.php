<?php

namespace Silktide\ProspectClient\Api;

use Silktide\ProspectClient\Http\HttpWrapper;
use Silktide\ProspectClient\Request\ScheduleReportRequest;

class ScheduledReportApi
{
    protected HttpWrapper $httpWrapper;

    public function __construct(HttpWrapper $httpWrapper)
    {
        $this->httpWrapper = $httpWrapper;
    }

    public function schedule(): ScheduleReportRequest
    {
        return new ScheduleReportRequest($this->httpWrapper);
    }
}
