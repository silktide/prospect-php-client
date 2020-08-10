<?php

namespace Silktide\ProspectClient\Entity;

class Report
{
    private array $data;

    private function __construct()
    {
    }

    public static function create(array $data) : Report
    {
        $report = new Report();
        $report->data = $data;
        return $report;
    }

    public function getReportId(): string
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

        return $this->data[$name] ?? null;
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
        return $this->data["meta"][$key] ?? null;
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    public function getValue(string $key)
    {
        return $this->data[$key] ?? null;
    }
}