<?php

namespace Silktide\ProspectClient\Entity;

abstract class AbstractEntity
{
    /** @var mixed */
    protected $jsonData;

    public function __construct($jsonData)
    {
        $this->jsonData = $jsonData;
    }
}