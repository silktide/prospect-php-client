<?php

namespace Silktide\ProspectClient\Response;

class CreateReportResponse extends ReportResponse
{

    public function getResolvedUrl(): ?string
    {
        return $this->response["resolved_url"] ?? null;
    }

    public function getProvidedUrl(): ?string
    {
        return $this->response["provided_url"] ?? null;
    }
}