<?php

namespace Silktide\ProspectClient\Entity;

class ReportCategory extends AbstractEntity
{
    public function getLabel(): string
    {
        return $this->jsonData["label"];
    }

    public function getScore(): float
    {
        return $this->jsonData["score"];
    }

    /** @return string[] */
    public function getSections(): array
    {
        return $this->jsonData["sections"];
    }
}