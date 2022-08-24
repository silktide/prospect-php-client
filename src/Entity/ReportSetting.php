<?php

namespace Silktide\ProspectClient\Entity;

class ReportSetting
{
    protected $value;
    protected string $type;
    protected string $id;

    public static function create(string $id, string $type, $value): self
    {
        $instance = new self();

        $instance->id = $id;
        $instance->type = $type;
        $instance->value = $value;

        return $instance;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value): void
    {
        $this->value = $value;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }
}