<?php

namespace Silktide\ProspectClient\Entity;

abstract class AbstractEntity
{
    /** @var array */
    protected $jsonData;

    public function __construct(array $jsonData)
    {
        $this->jsonData = $jsonData;
    }
}