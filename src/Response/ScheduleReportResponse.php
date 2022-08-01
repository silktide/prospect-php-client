<?php

namespace Silktide\ProspectClient\Response;

class ScheduleReportResponse extends AbstractResponse
{
    public function getStatus(): string
    {
        return $this->response['status'];
    }

    public function getSchedule(): array
    {
        return $this->response['schedule'];
    }
}
