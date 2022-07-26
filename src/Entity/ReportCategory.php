<?php

namespace Silktide\ProspectClient\Entity;

class ReportCategory
{
    private string $label;
    private float $score;
    private array $sections;

    public static function create(string $label, float $score, array $sections) : ReportCategory
    {
        $reportCategory = new ReportCategory();
        $reportCategory->label = $label;
        $reportCategory->score = $score;
        $reportCategory->sections = $sections;
        return $reportCategory;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getScore(): float
    {
        return $this->score;
    }

    /** @return string[] */
    public function getSections(): array
    {
        return $this->sections;
    }
}
