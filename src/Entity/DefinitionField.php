<?php

namespace Silktide\ProspectClient\Entity;

class DefinitionField
{
    private string $id;
    private string $label;
    private string $description;
    private string $type;
    private array $raw = [];

    /**
     * @var string[]
     */
    private array $scenarios = [];

    /**
     * @param string $id
     * @param string $label
     * @param string $description
     * @param string $type
     * @param string[] $scenarios
     * @param array $data
     * @return static
     */
    public static function create(string $id, string $label, string $description, string $type, array $scenarios, array $data): self
    {
        $definitions = new self();

        $definitions->id = $id;
        $definitions->label = $label;
        $definitions->description = $description;
        $definitions->type = $type;
        $definitions->scenarios = $scenarios;
        $definitions->raw = $data;

        return $definitions;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string[]
     */
    public function getScenarios(): array
    {
        return $this->scenarios;
    }

    public function getRawData(): array
    {
        return $this->raw;
    }
}
