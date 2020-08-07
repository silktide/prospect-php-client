<?php

namespace Silktide\ProspectClient\Response;

class CreateReportResponse extends AbstractResponse
{
    public function getReportId()
    {
        return $this->response['report_id'];
    }

    public function getReportStatus()
    {
        return $this->response['report_status'];
    }

    public function getResolvedUrl(): ?string
    {
        return $this->response["resolved_url"] ?? null;
    }

    public function getProvidedUrl(): ?string
    {
        return $this->response["provided_url"] ?? null;
    }
}