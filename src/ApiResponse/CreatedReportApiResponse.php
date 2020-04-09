<?php

namespace Silktide\ProspectClient\ApiResponse;

class CreatedReportApiResponse extends AbstractApiJsonResponse
{
    public function getCreatedId(): string {
        return $this->jsonResponse->{"reportId"};
    }
}