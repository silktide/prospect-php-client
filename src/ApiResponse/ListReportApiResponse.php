<?php

namespace Silktide\ProspectClient\ApiResponse;

use Silktide\ProspectClient\Entity\Report;

class ListReportApiResponse extends ReportApiResponse
{
    public function getReport(int $index): ?Report {
        if(!isset($this->jsonResponse->{"reports"}[$index])) {
            return null;
        }

        return new Report($this->jsonResponse->{"reports"}[$index]);
    }

    /** Report[] */
    public function getAllReports(): array {
        $allReports = [];
        $reportCount = count($this->jsonResponse->{"reports"});

        for($i = 0; $i < $reportCount; $i++) {
            $allReports []= $this->getReport($i);
        }

        return $allReports;
    }
}