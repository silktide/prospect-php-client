<?php

namespace Silktide\ProspectClient\Data;

use function \GuzzleHttp\json_encode;

class BodyData
{
    private array $kvp;

    public function __construct()
    {
        $this->kvp = [];
    }

    public function set(string $key, $value): void
    {
        $this->kvp[$key] = $value;
    }

    public function __toString(): string
    {
        return json_encode($this->kvp);
    }
}