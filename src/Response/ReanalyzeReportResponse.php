<?php

namespace Silktide\ProspectClient\Response;

class ReanalyzeReportResponse extends AbstractResponse
{
    public function getReportStatus() : string
    {
        return $this->response["status"];
    }

    public function getReportId() : string
    {
        return $this->response['reportId'];
    }
}