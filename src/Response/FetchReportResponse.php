<?php

namespace Silktide\ProspectClient\Response;

use Silktide\ProspectClient\Entity\Report;
use Silktide\ProspectClient\Entity\ReportCategory;

class FetchReportResponse extends ReportResponse
{
    public function getReport(): Report
    {
        return Report::create(
            $this->response['report'],
            $this->response['status'],
            $this->response['report_status']
        );
    }

    /**
     * @return ReportCategory[]
     */
    public function getCategories(): array
    {
        $categories = [];
        foreach($this->response["categories"] as $row) {
            $categories[$row["label"]] = ReportCategory::create($row["label"], $row["score"], $row["sections"]);
        }

        return $categories;
    }
}