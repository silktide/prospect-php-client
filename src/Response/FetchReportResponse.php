<?php

namespace Silktide\ProspectClient\Response;

use Silktide\ProspectClient\Entity\Report;
use Silktide\ProspectClient\Entity\ReportCategory;
use Silktide\ProspectClient\Entity\ReportPercentile;

class FetchReportResponse extends AbstractResponse
{
    public function getReport(): Report
    {
        return Report::create($this->response['report']);
    }

    public function getReportStatus() : string
    {
        return $this->response['report_status'];
    }

    /**
     * @return ReportCategory[]
     */
    public function getCategories(): array
    {
        $categories = [];
        foreach($this->response["report"]["categories"] ?? [] as $row) {
            $categories[$row["label"]] = ReportCategory::create($row["label"], $row["score"], $row["sections"]);
        }

        return $categories;
    }

    /**
     * @return ReportPercentile[]
     */
    public function getPercentiles(): array
    {
        $percentiles = [];
        foreach ($this->response["percentiles"] ?? [] as $row) {
            $percentiles[] = ReportPercentile::create(
                $row["type"],
                $row["industry"],
                $row["area"],
                $row["country"],
                $row["average"],
                $row["count"],
                $row["percentile"]
            );
        }
        return $percentiles;
    }

    public function getVersions() : array
    {
        return $this->response["versions"] ?? [];
    }
}