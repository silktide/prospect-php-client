<?php

namespace Silktide\ProspectClient\Entity;

class Report extends AbstractEntity
{
    public function getId(): string
    {
        return $this->jsonData->{"report_id"};
    }

    public function getAccountId(): string
    {
        return $this->jsonData->{"account_id"};
    }

    public function getDomain(): string
    {
        return $this->jsonData->{"domain"};
    }

    public function getOverallScore(): int
    {
        return $this->jsonData->{"overall_score"};
    }

    /**
     * @return object|null A plain PHP object with properties of the requested section, or null if
     * the section does not exist.
     */
    public function getReportSection(string $name): ?object
    {
        return $this->jsonData->{$name} ?? null;
    }
}