<?php

namespace Silktide\ProspectClient\Entity;

abstract class AbstractEntity
{
    /** @var array */
    protected $jsonData;
    /** @var array */
    protected $extraData;

    public function __construct(array $jsonData, array $extraData = [])
    {
        $this->jsonData = $jsonData;
        $this->extraData = $extraData;
    }
}