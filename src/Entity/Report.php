<?php

namespace Silktide\ProspectClient\Entity;

class Report extends AbstractEntity
{
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
        return $this->jsonData[$name] ?? null;
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