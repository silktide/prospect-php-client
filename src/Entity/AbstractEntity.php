<?php

namespace Silktide\ProspectClient\Entity;

abstract class AbstractEntity
{
    protected array $jsonData;

    public function __construct(array $jsonData)
    {
        $this->jsonData = $jsonData;
    }
}