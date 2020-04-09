<?php

namespace Silktide\ProspectClient\Api\Fields;

use Iterator;

abstract class AbstractApiFields implements Iterator
{
    protected array $keyValuePairs = [];
    private int $iteratorKey = 0;

    public function rewind(): void
    {
        $this->iteratorKey = 0;
    }

    public function key(): string
    {
        return $this->keyString();
    }

    public function valid(): bool
    {
        return !is_null($this->keyString());
    }

    public function current(): string
    {
        return $this->keyValuePairs[$this->keyString()];
    }

    public function next(): void
    {
        $this->iteratorKey++;
    }

    private function keyString(): ?string
    {
        $keys = array_keys($this->keyValuePairs);
        return $keys[$this->iteratorKey] ?? null;
    }
}