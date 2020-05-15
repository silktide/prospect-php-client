<?php

namespace Silktide\ProspectClient\ApiResponse;

use Silktide\ProspectClient\Entity\Report;
use Silktide\ProspectClient\Entity\ReportCategory;

class FetchReportApiResponse extends ReportApiResponse
{
    public function getReport(): Report
    {
        return new Report($this->jsonResponse["report"], [
            "status" => $this->jsonResponse["status"],
            "report_status" => $this->jsonResponse["report_status"],
        ]);
    }

    /** @return ReportCategory[] */
    public function getCategories(): array
    {
        $categories = [];
        foreach($this->jsonResponse["categories"] as $categoryData) {
            $categories[$categoryData["label"]] = new ReportCategory($categoryData);
        }

        return $categories;
    }
}