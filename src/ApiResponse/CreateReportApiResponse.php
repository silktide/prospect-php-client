<?php

namespace Silktide\ProspectClient\ApiResponse;

class CreateReportApiResponse extends ReportApiResponse {

    public function getResolvedUrl(): ?string
    {
        return $this->jsonResponse["resolved_url"] ?? null;
    }

    public function getProvidedUrl(): ?string
    {
        return $this->jsonResponse["provided_url"] ?? null;
    }
}