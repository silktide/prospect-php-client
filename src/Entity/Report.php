<?php

namespace Silktide\ProspectClient\Entity;

class Report// extends AbstractEntity
{
    private $status;
    private $reportStatus;
    private $data;

    private function __construct()
    {
    }

    public static function create(array $data, string $status, string $reportStatus)
    {
        $report = new Report();
        $report->data = $data;
        $report->status = $status;
        $report->reportStatus = $reportStatus;
        return $report;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getReportStatus(): string
    {
        return $this->reportStatus;
    }

    public function getId(): string
    {
        return $this->data["report_id"];
    }

    public function getAccountId(): string
    {
        return $this->data["account_id"];
    }

    public function getDomain(): string
    {
        return $this->data["domain"];
    }

    public function getOverallScore(): int
    {
        return $this->data["overall_score"];
    }

    /**
     * @return array|null An associative array with properties of the requested section, or null if
     * the section does not exist.
     */
    public function getReportSection(string $name): ?array
    {
        if(!is_array($this->data)) {
            return null;
        }

        return $this->jsonData[$name] ?? null;
    }

    public function getAllReportSections(): array
    {
        $skipKeys = ["meta"];
        $sections = $this->data;

        $sections = array_filter($sections, function($value, $key)use($skipKeys) {
            if(in_array($key, $skipKeys)) {
                return false;
            }
            if(!is_array($value)) {
                return false;
            }

            return true;
        }, ARRAY_FILTER_USE_BOTH);

        return $sections;
    }

    public function getMetaValue(string $key): ?string
    {
        return $this->jsonData["meta"][$key] ?? null;
    }

    public function getValue(string $key)
    {
        return $this->jsonData[$key] ?? null;
    }
}