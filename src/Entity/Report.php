<?php

namespace Silktide\ProspectClient\Entity;

class Report extends AbstractEntity
{
    public function getStatus(): string
    {
        return $this->extraData["status"];
    }

    public function getReportStatus(): string
    {
        return $this->extraData["report_status"];
    }

    public function getId(): string
    {
        return $this->jsonData["report_id"];
    }

    public function getAccountId(): string
    {
        return $this->jsonData["account_id"];
    }

    public function getDomain(): string
    {
        return $this->jsonData["domain"];
    }

    public function getOverallScore(): int
    {
        return $this->jsonData["overall_score"];
    }

    /**
     * @return array|null An associative array with properties of the requested section, or null if
     * the section does not exist.
     */
    public function getReportSection(string $name): ?array
    {
        if(!is_array($this->jsonData)) {
            return null;
        }

        return $this->jsonData[$name];
    }

    public function getAllReportSections(): array
    {
        $skipKeys = ["meta"];
        $sections = $this->jsonData;

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