<?php


namespace Silktide\ProspectClient\Entity;


class ReportPercentile
{
    private string $type;
    private ?string $industry;
    private ?string $area;
    private ?string $country;
    private float $average;
    private int $count;
    private int $percentile;

    private function __construct()
    {
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getIndustry(): ?string
    {
        return $this->industry;
    }

    public function getArea(): ?string
    {
        return $this->area;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function getAverage(): float
    {
        return $this->average;
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function getPercentile(): int
    {
        return $this->percentile;
    }

    public static function create(
        string $type,
        ?string $industry,
        ?string $area,
        ?string $country,
        float $average,
        int $count,
        int $percentile
    ) : ReportPercentile
    {
        $entity = new ReportPercentile();
        $entity->type = $type;
        $entity->industry = $industry;
        $entity->area = $area;
        $entity->country = $country;
        $entity->average = $average;
        $entity->count = $count;
        $entity->percentile = $percentile;
        return $entity;
    }
}